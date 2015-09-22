# SearchEngine Bundle

A [gnugat/search-engine](http://gnugat.github.io/search-engine/) integration in [Symfony](http://symfony.com/).

> **Caution**: this component does not provide actual SearchEngine features, if you're looking for one you should rather have a look at ElasticSearch, Solr, etc.
> See `gnugat/search-engine`'s' [website](http://gnugat.github.io/search-engine/) for more information.

This bundle provides the following services:

* `gnugat_search_engine.criteria_factory`: creates `Criteria` from Request query parameters
* `gnugat_search_engine.identifier_engine`: an instance of `IdentifierEngine`
* `gnugat_search_engine.search_engine`: an instance of `SearchEngine`
* `gnugat_search_engine.type_sanitizer`: an instance of `TypeSanitizer`

In order for it to work, you need to:

1. create an implementations of `Fetcher` (or install an existing one, like [PommSearchEngine](https://github.com/gnugat/pomm-search-engine))
2. define it as a service with the name `gnugat_search_engine.fetcher`

Also, to be able to find anything `SearchEngine` and `IdentifierEngine` both need you to add information about available resources.
This can be done by implementating `SelectBuilder` and define it as a service, for example:

```
services:
    app.blog_select_builder:
        class: AppBundle\SearchEngine\BlogSelectBuilder
        tags:
            -
                name: gnugat_search_engine.select_builder
                resource_name: blog
                resource_definition: |
                    {
                        "fields": {
                            "id": "integer",
                            "title": "string",
                            "author_id": "integer"
                        },
                        "relations": ["author"]
                    }
```

We can finally use it, for example in a controller:

```php
<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * Full URL example: /v1/blogs?title=IG&sort=author_id,-title&page=2&per_page=1
     *
     * @Route("/v1/blogs")
     * @Method({"GET"})
     */
    public function searchAction(Request $request)
    {
        $criteriaFactory = $this->container->get('gnugat_search_engine.criteria_factory');
        $searchEngine = $this->container->get('gnugat_search_engine.search_engine');

        $criteria = $criteriaFactory->fromQueryParameters('blog', $request->query->all());
        $results = $searchEngine->match($criteria);

        return new Response(json_encode($results), 200, array('Content-Type' => 'application/json'));
    }
}
```

> **Tip**: instead of using these services directly in the controller, we can inject
> them in other services.

## Installation

To install `gnugat/search-engine-bundle`, run the following command:

    composer require gnugat/search-engine-bundle:^0.2

Then register `Gnugat\SearchEngineBundle\GnugatSearchEngineBundle` in `AppKernel.php`

## Further documentation

You can see the current and past versions using one of the following:

* the `git tag` command
* the [releases page on Github](https://github.com/gnugat/search-engine-bundle/releases)
* the file listing the [changes between versions](CHANGELOG.md)

You can find more documentation at the following links:

* [copyright and MIT license](LICENSE)
* [versioning and branching models](VERSIONING.md)
* [contribution instructions](CONTRIBUTING.md)
