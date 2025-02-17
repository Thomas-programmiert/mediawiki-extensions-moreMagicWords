# mediawiki-extensions-moreMagicWords
Provides a magic word `{{CONTENTMODEL}}` to retrieve the content model of a page.

This is useful for a hack when abusing Mediawiki:Clearyourcache to include documentation pages to pages in Mediawiki namespace `{{#ifexist: {{FULLPAGENAME}}/doc| {{ {{FULLPAGENAME}}/doc }} }}`
