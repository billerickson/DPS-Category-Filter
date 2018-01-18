# Category Filter for Display Posts Shortcode #

Filter results of [display-posts] using [dps_category_filter]

## Description ##

When using [Display Posts Shortcode](https://github.com/billerickson/display-posts-shortcode), this plugin lets you add dropdown menus to filter the results by one or more categories. It will respect the category parameters already existing in the shortcode.

Include a comma-separated list of category slugs, and for each category a dropdown will appear showing all its children.

When viewing a page, after you select some categories and click "Filter Results", the page is reloaded and the listing is limited to posts matching those subcategories.

Your page content may look like this:

```
[dps_category_filter categories="cuisine,other"]

[display-posts]
```

Where Cuisine and Other are top level categories:

![screenshot](https://d3vv6lp55qjaqc.cloudfront.net/items/2c0H1P1E1x2y450X2O38/Screen%20Shot%202018-01-18%20at%203.49.56%20PM.png?X-CloudApp-Visitor-Id=095a13821a9a7633d8999bdb4bf2b94a&v=e4a03a69)

Video of filters in action: https://cl.ly/2W3K1r1m0k3m

[![video screenshot](https://d3vv6lp55qjaqc.cloudfront.net/items/1e3H0V3s45152f3r1D1A/Screen%20Shot%202018-01-18%20at%203.52.54%20PM.png?X-CloudApp-Visitor-Id=095a13821a9a7633d8999bdb4bf2b94a&v=ef5b4126)
](https://cl.ly/2W3K1r1m0k3m)
