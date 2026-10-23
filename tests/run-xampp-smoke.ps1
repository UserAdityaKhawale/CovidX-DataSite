param([string]$BaseUrl = 'http://127.0.0.1/covid-information-website')
$ErrorActionPreference = 'Stop'
Add-Type -AssemblyName System.Net.Http
$handler = [System.Net.Http.HttpClientHandler]::new()
$handler.AllowAutoRedirect = $false
$handler.CookieContainer = [System.Net.CookieContainer]::new()
$client = [System.Net.Http.HttpClient]::new($handler)
$uri = [Uri]$BaseUrl
$checks = [System.Collections.Generic.List[string]]::new()
$tag = 'qa' + [Guid]::NewGuid().ToString('N').Substring(0,10)
$password = 'Qwerty!234'
$created = $false

function Assert-That([bool]$condition, [string]$message) {
    if (-not $condition) { throw "FAIL: $message" }
    $script:checks.Add("PASS: $message")
}
function Get-Page([string]$path) {
    $response = $script:client.GetAsync("$($script:BaseUrl)/$path").GetAwaiter().GetResult()
    [pscustomobject]@{ Status = [int]$response.StatusCode; Location = [string]$response.Headers.Location; Body = $response.Content.ReadAsStringAsync().GetAwaiter().GetResult() }
}
function Get-Csrf([string]$path) {
    $page = Get-Page $path
    Assert-That ($page.Status -eq 200) "GET $path returns HTTP 200"
    $match = [regex]::Match($page.Body, 'name="csrf_token" value="([a-f0-9]+)"')
    if (-not $match.Success) { throw "No CSRF token found on $path" }
    return $match.Groups[1].Value
}
function Send-Form([string]$path, [hashtable]$fields) {
    $pairs = [System.Collections.Generic.List[System.Collections.Generic.KeyValuePair[string,string]]]::new()
    foreach ($key in $fields.Keys) { $pairs.Add([System.Collections.Generic.KeyValuePair[string,string]]::new([string]$key, [string]$fields[$key])) }
    $content = [System.Net.Http.FormUrlEncodedContent]::new($pairs)
    $response = $script:client.PostAsync("$($script:BaseUrl)/$path", $content).GetAwaiter().GetResult()
    [pscustomobject]@{ Status = [int]$response.StatusCode; Location = [string]$response.Headers.Location; Body = $response.Content.ReadAsStringAsync().GetAwaiter().GetResult() }
}

try {
    $registerToken = Get-Csrf 'register.php'
    $register = Send-Form 'register.php' @{ csrf_token=$registerToken; full_name='QA Demo'; username=$tag; email="$tag@example.com"; password=$password; phone='9876543210'; age='30'; city='Pune'; vaccination_status='Not vaccinated' }
    Assert-That ($register.Status -eq 302 -and $register.Location -match 'login\.php') 'Valid registration redirects to login'
    $created = $true

    $loginToken = Get-Csrf 'login.php'
    $before = $handler.CookieContainer.GetCookies($uri)['PHPSESSID'].Value
    $login = Send-Form 'login.php' @{ csrf_token=$loginToken; username=$tag; password=$password }
    $after = $handler.CookieContainer.GetCookies($uri)['PHPSESSID'].Value
    Assert-That ($login.Status -eq 302 -and $login.Location -match 'index\.php') 'Valid login redirects to dashboard'
    Assert-That ($before -ne $after) 'Session ID rotates after login'

    $dashboard = Get-Page ''
    Assert-That ($dashboard.Status -eq 200 -and $dashboard.Body.Contains('44,998,520')) 'Authenticated dashboard renders the seeded report snapshot'
    $data = Get-Page 'data.php'
    Assert-That ($data.Status -eq 200 -and $data.Body.Contains('India') -and $data.Body.Contains('Not reported')) 'Data page preserves the India row and unavailable death value'

    $vaxToken = Get-Csrf 'vaccination.php'
    $vax = Send-Form 'vaccination.php' @{ csrf_token=$vaxToken; full_name='QA Demo'; age='30'; city='Pune'; phone='9876543210'; vaccination_status='Fully vaccinated'; vaccine_or_dose='Dose 2' }
    Assert-That ($vax.Status -eq 302 -and $vax.Location -match 'vaccination\.php') 'Vaccination record saves and redirects'
    $vaxPage = Get-Page 'vaccination.php'
    Assert-That ($vaxPage.Status -eq 200 -and $vaxPage.Body.Contains('Fully vaccinated')) 'Saved vaccination record persists on reload'

    $commentToken = Get-Csrf 'comments.php'
    $unsafe = Send-Form 'comments.php' @{ csrf_token=$commentToken; comment='<script>alert(1)</script>' }
    Assert-That ($unsafe.Status -eq 200 -and $unsafe.Body -notmatch '<script>alert\(1\)</script>') 'HTML injection comment is rejected and not reflected as executable markup'
    $commentToken = [regex]::Match($unsafe.Body, 'name="csrf_token" value="([a-f0-9]+)"').Groups[1].Value
    $comment = Send-Form 'comments.php' @{ csrf_token=$commentToken; comment='QA smoke test comment' }
    Assert-That ($comment.Status -eq 302 -and $comment.Location -match 'comments\.php') 'Valid comment saves and redirects'
    $commentsPage = Get-Page 'comments.php'
    Assert-That ($commentsPage.Status -eq 200 -and $commentsPage.Body.Contains('QA smoke test comment')) 'Saved comment persists and appears after reload'

    $logoutToken = [regex]::Match($commentsPage.Body, 'name="csrf_token" value="([a-f0-9]+)"').Groups[1].Value
    $logout = Send-Form 'logout.php' @{ csrf_token=$logoutToken }
    Assert-That ($logout.Status -eq 302 -and $logout.Location -match 'login\.php') 'Logout ends session and redirects to login'
    $restricted = Get-Page 'comments.php'
    Assert-That ($restricted.Status -eq 302 -and $restricted.Location -match 'login\.php') 'Protected comments page redirects after logout'

    $checks | ForEach-Object { Write-Output $_ }
    Write-Output "E2E smoke checks passed: $($checks.Count); failed: 0"
} finally {
    if ($created) {
        $mysql = 'C:\xampp\mysql\bin\mysql.exe'
        $safeTag = $tag -replace '[^A-Za-z0-9_]', ''
        & $mysql --protocol=tcp --host=127.0.0.1 --user=root --database=covid_db --execute="DELETE FROM users WHERE username='$safeTag';" | Out-Null
    }
    $client.Dispose()
    $handler.Dispose()
}
