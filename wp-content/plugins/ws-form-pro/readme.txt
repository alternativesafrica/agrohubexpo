=== WS Form PRO ===
Contributors: westguard
Requires at least: 4.4
Tested up to: 5.5.3
Stable tag: trunk
Requires PHP: 5.6

WS Form PRO allows you to build faster, effective, user friendly WordPress forms. Build forms in a single click or use the unique drag and drop editor to create forms in seconds.

== Description ==

= Build Better WordPress Forms =

WS Form lets you create any form for your website in seconds using our unique drag and drop editor. Build everything from simple contact us forms to complex multi-page application forms.

== Installation ==

For help installing WS Form, please see our [Installation](https://wsform.com/knowledgebase/installation/?utm_source=wp_plugins&utm_medium=readme) knowledge base article.

== Changelog ==

= 1.7.94 =
* Bug Fix: Conditional logic action running

= 1.7.93 =
* Added: Improvements to object, action and conditional logic save / save & close methods
* Bug Fix: Elementor frontend fix

= 1.7.92 =
* Added: Improved form populate null checks

= 1.7.91 =
* Added: Framework improvements for required fields
* Added: Layout editor UI improvements

= 1.7.90 =
* Added: Error handling disabled in visual builder previews
* Bug Fix: Inline CSS rendering in Gutenberg

= 1.7.89 =
* Bug Fix: Upload mime type filtering in repeatable sections

= 1.7.88 =
* Added: Changes made to improve compatibility with WP Rocket

= 1.7.87 =
* Added: Form level restrictions by user role and/or capabilities
* Added: Field level restrictions by user role and/or capabilities
* Added: Data grid row variables 
* Bug Fix: Required file uploads on hidden file fields

= 1.7.86 =
* Bug Fix: Removed form ID check on submit db_update
* Bug Fix: Minor fix on plugin page links

= 1.7.85 =
* Bug Fix: Column mapping on select2 AJAX searching

= 1.7.84 =
* Bug Fix: Admin function hook adjustment to ensure CPTs recognized by post management add-on

= 1.7.83 =
* Added: Further improvements and additions to the template library
* Added: Hidden field value setting and resetting with conditional logic
* Added: Improved API call error response handling with KB support
* Bug Fix: #calc registration in submissions editor sidebar
* Bug Fix: #calc log events when debug not shown
* Bug Fix: Mobile to desktop breakpoint sidebar handling in admin

= 1.7.82 =
* Bug Fix: Gutenberg block

= 1.7.81 =
* Added: Improved template library layout and dynamic SVG generator
* Added: Media attachments for send email action
* Bug Fix: Ratings field on mobile

= 1.7.80 =
* Added: Functionality added for WooCommerce extension version 1.1.41
* Added: Calculated templates
* Added: Read only attribute on rating field type
* Bug Fix: Progress bar events when repeatable section row added
* Bug Fix: Double clicking on field labels while editing

= 1.7.79 =
* Added: wsf_form_init() function to allow adhoc forms to be initialized

= 1.7.78 =
* Added: Form statistics reset

= 1.7.77 =
* Bug Fix: Conditional logic optgroups

= 1.7.76 =
* Added: Prefix and suffix support on fields (Fully Bootstrap and Foundation compatible using input groups)
* Bug Fix: Latest version of CodeMirror caused re-initialize issue

= 1.7.75 =
* Changed: Improved auto else feature on conditional logic so it doesn't apply to event conditions
* Bug Fix: Signature reset conditional logic action firing event
* Bug Fix: Color field reset updating minicolor jQuery component

= 1.7.74 =
* Added: Select2 option on select fields (Supports AJAX)
* Added: Ability to override form element ID in shortcode (element_id)
* Added: Ability to override form element ID in block
* Added: Exclude hidden fields option under screen options in Submissions
* Changed: Clear hidden fields functionality improved

= 1.7.73 =
* Bug Fix: Required conditional logic action

= 1.7.72 =
* Added: Undo, redo and undo history now updates preview
* Changed: Further conditional logic performance improvements

= 1.7.71 =
* Added: Additional tutorial items
* Changed: Conditional logic performance improvements
* Changed: Repeatable section performance improvements
* Changed: Debug console log performance improvements
* Bug Fix: Action and conditional logic read only header

= 1.7.70 =
* Added: Time min/max and invalid input validation on fields using jQuery date/time picker
* Bug Fix: CodeMirror initialization on hidden fields

= 1.7.69 =
* Bug Fix: Return/enter events on input fields
* Bug Fix: Repeatable section hidden fields not cleared

= 1.7.68 =
* Added: Field label save on return/enter
* Bug Fix: Initial action label saving

= 1.7.67 =
* Added: Hidden behavior options on fields: Always Include in Actions, Always Include in Cart Total
* Added: Ability to edit e-commerce fields in submissions (Setting)
* Bug Fix: Show all if no results option on cascading selects (Non-AJAX)

= 1.7.66 =
* Added: File upload image, video and audio previewing

= 1.7.65 =
* Bug Fix: Checkbox and radio grids with cascading values

= 1.7.64 =
* Added: Hidden fields are cleared in emails by default (Can be disabled)
* Added: Hidden fields can be cleared in submissions
* Bug Fix: Validation on hidden fields (HTML 5 compatible)
* Bug Fix: Removed title and meta from fallback preview template
* Bug Fix: Required hidden fields

= 1.7.63 =
* Bug Fix: wsf-rendered trigger

= 1.7.62 =
* Added: Form rendered condition
* Added: Cascading support on multi selects
* Bug Fix: Form navigation firing order

= 1.7.61 =
* Added: AJAX cascading select fields
* Added: Cascading checkboxes
* Added: Support for text, number, range, and rating fields as cascading inputs
* Added: Placeholder text for cascading fields (No results and loading for AJAX requests)
* Added: Improved loader when adding a new form
* Bug Fix: Repeatable section icon coloring
* Bug Fix: Data grid page selectors for high numbers

= 1.7.60 =
* Added: Filter by author in post data source
* Changed: Checkbox and radio styling in WS Form framework
* Bug Fix: Select cascading in Safari

= 1.7.59 =
* Added: Performance improvements
* Added: Improved presentation of dragged fields
* Changed: System table reorganization
* Bug Fix: Min, max validation of fields in repeatable sections
* Bug Fix: Cascading removing events

= 1.7.58 =
* Added: Deduplication of select, radio and checkbox options across repeatable sections

= 1.7.57 =
* Bug Fix: CodeMirror saving in sidebar

= 1.7.56 =
* Added: Improved hide/show conditional logic performance

= 1.7.55 =
* Added: Retained file uploads on form save
* Added: Visual tickmarks on range sliders (Chrome only)
* Added: Custom file upload button label setting

= 1.7.54 =
* Bug Fix: Image selector in data grids

= 1.7.53 =
* Added: Sorting on sidebar repeaters
* Bug Fix: Set custom validity on radio field

= 1.7.52 =
* Bug Fix: Column mapping indexes / ids

= 1.7.51 =
* Added: Ability to to set min / max dates based on + / - days using +1970-01-05 format (e.g. + 4 days)
* Added: Improved detection of date time picker presence (avoids clash with Divi date time picker)

= 1.7.50 =
* Added: Human Presence spam protection
* Changed: Akismet spam protection now found under Form Settings, Spam tab

= 1.7.49 =
* Added: Save form list orderby and order settings by user
* Added: Validation for dates with ordinal indicators
* Changed: Removed DELETE and PUT verbs throughout

= 1.7.48 =
* Added: Minor sidebar CSS fixes
* Bug Fix: Set custom validity only if field will validate

= 1.7.47 =
* Added: Conditional logic date comparison for d/m/Y format
* Changed: Improved Form Settings sidebar layout
* Changed: Improved sidebar CSS throughout

= 1.7.46 =
* Changed: Updated date time picker jQuery component

= 1.7.45 =
* Bug Fix: Field bypassing on hidden file fields
* Bug Fix: Initial rendering of publish button after performance improvements

= 1.7.44 =
* Added: Language support on jQuery date time picker
* Bug Fix: Select all on bulk edit in data grids

= 1.7.43 =
* Added: Min and max date validation on jQuery date picker
* Added: autocomplete options for fields

= 1.7.42 =
* Added: Submissions export filtered by date range
* Added: Improved loading speed of submissions and layout editor
* Changed: Submissions date columns formatted according to field settings

= 1.7.41 =
* Bug Fix: Conditional logic for actions

= 1.7.40 =
* Changed: Select2 REST API authentication for WordPress 5.5+
* Bug Fix: Invalid feedback targeting in conditional logic actions

= 1.7.39 =
* Bug Fix: Submission column ordering

= 1.7.38 =
* Added: Populate field triggering fallback
* Bug Fix: Calc registration on conditional logic actions
* Bug Fix: Conditional logic setting values on price field now currency formatted for input currency mask

= 1.7.37 =
* Bug Fix: Event firing in multiple conditional groups
* Bug Fix: Conditional logic field targeting

= 1.7.36 =
* Bug Fix: Localization of conditional logic in same section

= 1.7.35 =
* Bug Fix: Fallback calc value

= 1.7.34 =
* Added: Support for calc with price column mapping
* Bug Fix: Calc on negative price values

= 1.7.33 =
* Added: Price subtotal and cart total fields now trigger calc fields
* Bug Fix: Minor edit on 'Read Only' setting in admin

= 1.7.32 =
* Added: New reset and clear icons for repeatable section
* Added: Tab, section and field reset and clear conditional logic actions
* Added: Setting to show all options if cascading lookup cannot find a match
* Changed: Improved conditional logic targeting on repeatable sections

= 1.7.31 =
* Added: Various layout editor UI improvements
* Bug Fix: Stacked conditional logic actions
* Bug Fix: Deleted conditional groups caused logic previous to be incorrect

= 1.7.30 =
* Changed: Select, radio and checkbox price mapping can now contain values with currency

= 1.7.29 =
* Added: #section_row_count now works on initial form load
* Bug Fix: Repeatable section radio and checkbox value conditional logic
* Bug Fix: Conditional logic firing when sections are cloned

= 1.7.28 =
* Added: Support for optgroups and fieldsets in cascading select and radio fields
* Bug Fix: Tab selection in Bootstrap 5
* Bug Fix: Data grid column delete removed for single column grids

= 1.7.27 =
* Added: Conditional logic for checked count equals, does not equal, greater than, less than on checkbox fields
* Added: Conditional logic for selected count equals, does not equal, greater than, less than on select fields
* Added: Max checked count limits checking additional checkboxes on checkbox fields
* Added: Max selected count limits selecting additional options on select fields

= 1.7.26 =
* Added: Debug populate feature now excludes fields with calculated values
* Added: Improved debug populate event firing
* Bug Fix: Price select cascading column selection fix

= 1.7.25 =
* Added: Ability to include dividers in emails
* Added: Added wpautop to text editor field output in emails
* Added: Full width value fields in expanded conditional logic view
* Bug Fix: Deactivation fixed if moving between hostnames
* Bug Fix: Added additional new lines to email content to avoid hitting line limit
* Bug Fix: @unserialize was incorrectly causing errors in WP 5.5 so changed this to is_serialized method
* Bug Fix: Removed double <p> tags in email content caused by output of wpautop

= 1.7.24 =
* Added: Dismiss nag fixed

= 1.7.23 =
* Added: Action variable column mapping on price select, checkbox and radio fields

= 1.7.22 =
* Added: LinkedIn conversion tracking
* Changed: Improved settings layout
* Bug Fix: Foundation checkbox and radio field markup

= 1.7.21 =
* Added: Improved support for WAF 403 errors
* Changed: X-HTTP-Method-Override disabled by default

= 1.7.20 =
* Added: Support for minumum and maximum selected/checked in progress bar calculations
* Added: Minimum and maximum checked on price checkbox
* Added: Minimum and maximum selected on price select
* Changed: Improved support for min and max dates for native and jQuery date picker

= 1.7.19 =
* Added: Ability to add click events to navigation buttons
* Bug Fix: Reset and clear applying to fields in repeatable sections

= 1.7.18 =
* Added: Improved rendering of images in submissions table
* Bug Fix: Wrapping submission labels
* Bug Fix: Count submit unread API for submissions

= 1.7.17 =
* Added: Section width support for action update_form method

= 1.7.16 =
* Bug Fix: Unchecked checkboxes now equals 0 in calculations

= 1.7.15 =
* Added: Table CSS added to override issue caused by poor CSS selectors in third party plugins
* Bug Fix: Divi shortcode

= 1.7.14 =
* Bug Fix: ID's on multiple case sensitive checkboxes in conditional logic

= 1.7.13 =
* Added: #pow(base, exponent) variable
* Added: #ecommerce_price(number) variable
* Added: Array to comma delimited setting in custom endpoint action
* Changed: Revised REST endpoint declarations to meet 5.5 requirements

= 1.7.12 =
* Added: Public and mobile toolbar menu features

= 1.7.11 =
* Added: Admin toolbar menu features

= 1.7.10 =
* Added: select_option_text, checkbox_label, radio_label as server side variables
* Bug Fix: Required attributes on variables

= 1.7.9 =
* Added: Bootstrap 5 framework support
* Added: Hooks for TinyMCE configuration
* Added: Improved welcome screen
* Bug Fix: Case sensitivity in conditional logic
* Bug Fix: Gutenberg block fix for visual editor

= 1.7.8 =
* Added: Data grid 'Insert Image' icon
* Added: Select field minimum and maximum selected

= 1.7.7 =
* Added: Section ID's hidden in emails if they are empty
* Bug Fix: Pre-parsing

= 1.7.6 =
* Bug Fix: Calculated field

= 1.7.5 =
* Added: #post_meta, #user_meta now works in all fields
* Added: Various UI improvements

= 1.7.4 =
* Added: Improvements to visual builder modules
* Bug Fix: Data grid tab JS error on click for read only grids

= 1.7.3 =
* Bug Fix: Repeatable section calculations on section add

= 1.7.2 =
* Added: Improved API / Database error handling
* Added: Theme and MySQL variable added to system report
* Changed: Framework detection in settings

= 1.7.1 =
* Bug Fix: mod_security fix

= 1.7.0 =
* Added: Data sources for select, checkbox, radio and fields supporting datalists
* Added: Data source: Preset (Country, State etc)
* Added: Data source: Post (Posts, Pages etc)
* Added: Data source: Term (Category, Tag etc)
* Added: Data source: User
* Added: Data source: ACF (Field choices)
* Added: New value based conditional logic If/Then/Else options
* Changed: Various admin interface styling improvements
* Bug Fix: Changed 'per page' functionality for compatibility with 5.4.2
* Bug Fix: Tab previous and next buttons if no tabs present
