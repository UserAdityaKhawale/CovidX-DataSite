<?php
require __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Dashboard';
require __DIR__ . '/includes/header.php';
?>
<main class="container page-space">
  <section class="welcome-grid">
    <div><span class="eyebrow"><i class="live-dot"></i> ACADEMIC DEMONSTRATION DATA</span><h1><?= current_user() ? 'Welcome, ' . h(current_user()['username']) . '<br>' : '' ?>India &amp; Maharashtra<br><span class="accent">COVID-19 trajectory</span></h1><p class="lead">A calm, clear view of the figures included in the STQA project report, with practical information and tools for the community.</p><div class="actions"><a class="button primary" href="data.php">Explore the data <span aria-hidden="true">→</span></a><a class="button ghost" href="about.php">Know the basics</a></div></div>
    <aside class="source-card"><div class="source-icon">✳</div><div><strong>Data transparency</strong><p>The figures below are transcribed from the report’s dashboard mock-up. They are undated demonstration values, not current surveillance data.</p><a href="data.php">Read the data notes <span aria-hidden="true">↗</span></a></div></aside>
  </section>
  <section class="stats-grid" aria-label="COVID-19 snapshot from the project report">
    <article class="stat-card"><div class="stat-top"><span>Reported cases</span><span class="stat-icon cyan">✳</span></div><strong class="stat-number">44,998,520</strong><div class="stat-foot"><span class="pill neutral">India · report mock-up</span></div></article>
    <article class="stat-card"><div class="stat-top"><span>Reported deaths</span><span class="stat-icon" style="background:#42282b;color:#ff9085">!</span></div><strong class="stat-number stat-unavailable">Not reported</strong><div class="stat-foot"><span class="pill neutral">Not present in report</span></div></article>
    <article class="stat-card"><div class="stat-top"><span>Active hospitalizations</span><span class="stat-icon violet">▣</span></div><strong class="stat-number">1,824</strong><div class="stat-foot"><span class="pill warn">India · report mock-up</span></div></article>
    <article class="stat-card"><div class="stat-top"><span>Total discharged</span><span class="stat-icon green">♥</span></div><strong class="stat-number">44,646,120</strong><div class="stat-foot"><span class="pill good">India · report mock-up</span></div></article>
    <article class="stat-card"><div class="stat-top"><span>Doses administered</span><span class="stat-icon blue">✚</span></div><strong class="stat-number">2,206,750,000</strong><div class="stat-foot"><span class="pill neutral">India · report mock-up</span></div></article>
  </section>
  <div class="timestamp-row"><span>Source: undated dashboard mock-up embedded in the STQA mini-project report</span><span><span class="tiny-dot"></span> Historical/demo snapshot · not live</span></div>
  <section class="preview-row panel"><div><span class="eyebrow">COUNTRY SNAPSHOT</span><h2>India</h2><p>Only country figure set supplied in the project report.</p></div><div class="preview-metric"><small>Reported cases</small><strong>44,998,520</strong></div><div class="preview-metric"><small>Reported deaths</small><strong class="muted">Not reported</strong></div><a class="text-link" href="data.php">View data notes →</a></section>
  <section class="section-heading"><div><span class="eyebrow">YOUR NEXT STEP</span><h2>Health information, made useful</h2></div><a class="text-link" href="about.php">View prevention guidance →</a></section>
  <section class="feature-grid">
    <a class="feature-card" href="data.php"><span class="feature-icon blue">⌕</span><span class="feature-copy"><strong>Explore COVID-19 data</strong><small>Review the source, limits, and available country figures.</small></span><span class="feature-arrow">↗</span></a>
    <a class="feature-card" href="about.php"><span class="feature-icon green">✚</span><span class="feature-copy"><strong>Symptoms &amp; prevention</strong><small>Learn common symptoms and when to seek care.</small></span><span class="feature-arrow">↗</span></a>
    <a class="feature-card" href="vaccination.php"><span class="feature-icon violet">▣</span><span class="feature-copy"><strong>Vaccination register</strong><small>Save a demonstration record to your account.</small></span><span class="feature-arrow">↗</span></a>
  </section>
  <section class="callout"><div><span class="eyebrow">COMMUNITY</span><h2>Share a thoughtful note</h2><p>Signed-in members can leave a short comment for this academic demonstration.</p></div><a class="button secondary" href="comments.php">Open comments <span aria-hidden="true">→</span></a></section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
