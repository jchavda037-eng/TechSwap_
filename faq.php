<?php
// faq.php — FAQ Page
session_start();
$pageTitle = 'FAQ — TechSwap';
$activePage = 'faq';
include '_header.php';
?>

<!-- ============ FAQ ============ -->
<section class="section" id="faq" style="padding-top: 64px;">
  <div class="container">
    <div class="section-header">
      <div class="tag">FAQ</div>
      <h2>Questions? We've got answers.</h2>
      <p>Everything you need to know about buying and selling on TechSwap.</p>
    </div>
    <div class="faq-list" id="faqList">
      <!-- Filled by JS renderFAQ() -->
    </div>
  </div>
</section>

<!-- Contact CTA -->
<section class="section-sm" style="background: var(--bg2);">
  <div class="container" style="text-align:center;">
    <div class="tag" style="margin-bottom:16px;">Still have questions?</div>
    <h2 style="font-size:clamp(1.6rem,3vw,2.2rem);margin-bottom:12px;">We're here to help</h2>
    <p style="color:var(--text2);margin-bottom:28px;max-width:420px;margin-left:auto;margin-right:auto;">
      Our support team is available 7 days a week via WhatsApp. We typically respond within minutes.
    </p>
    <button class="btn btn-primary btn-lg" onclick="openWhatsApp('','Hi! I have a question about TechSwap.')">
      💬 Chat with Support
    </button>
  </div>
</section>

<?php include '_footer.php'; ?>
