<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <link rel="shortcut icon" href="<?php echo $root; ?>favicon.ico" type="image/x-icon" />
    <meta name="robots" content="noodp"/>
    <title><?php echo $title ?></title>
    <meta name="description" content="<?php echo $description ?>"/>
    <link rel="canonical" href="<?php echo $canon ?>" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo $title ?>" />
    <meta property="og:description" content="<?php echo $description ?>" />
    <meta property="og:url" content="<?php echo $canon ?>" />
    <meta property="og:site_name" content="TimeTracker" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo $title ?>" />
    <meta name="twitter:description" content="<?php echo $description ?>" />
    <meta name="twitter:site" content="@jeffbyerinc" />
    <meta name="twitter:creator" content="@globaljeff" />
    <link rel="stylesheet" href="<?php echo $root; ?>timetracker/css/screen.css" type="text/css" />
    <script>
      (function(){
        var data = {
            "@context": "http://schema.org",
            "@type": "WebPage",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "<?php echo $canon; ?>#"
            },
            "headline": "<?php echo $title; ?>",
            "author": {
                "@type": "Person",
                "name": "Jeff Byer"
            },
            "publisher": {
                "@type": "Organization",
                "name": "Byer Co"
            },
            "description": "<?php echo $description; ?>"
        }
        var script = document.createElement('script');
        script.type = "application/ld+json";
        script.innerHTML = JSON.stringify(data);
        document.getElementsByTagName('head')[0].appendChild(script); 
      })(document);
    </script>
  </head>