---
title: WebberZone ACF Country
description: A Country field type for Advanced Custom Fields. Drop-in compatible, English ISO 3166-1 country list, no build step.
permalink: /
---

<div class="hero">
  <div class="eyebrow">Free &middot; Open Source &middot; No Account</div>
  <h1>A <em>Country</em> field for ACF that just works</h1>
  <p class="lead">WebberZone ACF Country adds a proper <code>Country</code> field type to Advanced Custom Fields: a select of every ISO 3166-1 country, in English, with the same options and saved-value structure as a standard ACF select field.</p>
  <div class="hero-ctas">
    <a href="#installation" class="btn-primary">Installation</a>
    <a href="https://github.com/WebberZone/webberzone-acf-country/releases/latest" target="_blank" class="btn-outline">Download Latest Release</a>
    <a href="https://github.com/WebberZone/webberzone-acf-country" target="_blank" class="btn-outline">View on GitHub</a>
  </div>
</div>

<div class="home-section">
  <div class="eyebrow">Overview</div>
  <h2 class="section-title" style="margin-bottom:8px;">A clean, minimal field type</h2>
  <p style="color:var(--wz-warm-grey); max-width:64ch;">The field type registers on ACF's own <code>acf/include_field_types</code> hook, so it's always available regardless of theme or plugin load order.</p>

  <div class="feature-grid">
    <div class="feature-card">
      <h3>Country select field</h3>
      <p>Every ISO 3166-1 country, in English, presented as a standard ACF select field.</p>
    </div>
    <div class="feature-card">
      <h3>Same options as core select</h3>
      <p>Allow null, allow multiple, and default value, configured exactly like a native ACF select field.</p>
    </div>
    <div class="feature-card">
      <h3>Three return formats</h3>
      <p>Country code and name together, code only, or name only, set per field.</p>
    </div>
  </div>
</div>

<div class="home-section" style="padding-top:0;">
  <div class="eyebrow">Compatibility</div>
  <h2 class="section-title" style="margin-bottom:8px;">Drop-in replacement, no data migration</h2>
  <p style="color:var(--wz-warm-grey); max-width:64ch;">Field configuration and saved values use the same structure as a standard ACF select field. If you're switching from another Country field-type plugin built on the same convention, your existing field groups and saved data keep working. Nothing to re-save or migrate.</p>
</div>

<div class="home-section" style="padding-top:0;" markdown="1">
  <div class="eyebrow">Extend it</div>
  <h2 class="section-title" style="margin-bottom:8px;">Filter the country list</h2>
  <p style="color:var(--wz-warm-grey); max-width:64ch; margin-bottom: 0;">Remove or add countries with the <code>wzacf_countries</code> filter:</p>

```php
add_filter( 'wzacf_countries', function( $countries ) {
	unset( $countries['AQ'] ); // Remove Antarctica.
	return $countries;
} );
```

</div>

<div class="home-section" id="installation" style="padding-top:0;">
  <div class="eyebrow">Get started</div>
  <h2 class="section-title" style="margin-bottom:8px;">Installation</h2>

  <ol class="step-list">
    <li>
      <h3>Install the plugin</h3>
      <p>Upload the plugin files to <code>/wp-content/plugins/webberzone-acf-country</code>, or install it through the WordPress plugins screen directly.</p>
    </li>
    <li>
      <h3>Activate it</h3>
      <p>Activate the plugin through the <strong>Plugins</strong> screen in WordPress. Requires Advanced Custom Fields (or ACF PRO) to be installed and active.</p>
    </li>
    <li>
      <h3>Add the field</h3>
      <p>Add a field of type <strong>Country</strong> to any ACF field group.</p>
    </li>
  </ol>
</div>

<div class="home-section" style="padding-top:0;">
  <div class="eyebrow">Requirements</div>
  <h2 class="section-title" style="margin-bottom:8px;">What you need</h2>
  <p style="color:var(--wz-warm-grey); max-width:64ch;">WordPress 6.6+, PHP 7.4+, and Advanced Custom Fields (or ACF PRO). See the <a href="https://github.com/WebberZone/webberzone-acf-country/releases" target="_blank">releases</a> page for the changelog.</p>
</div>
