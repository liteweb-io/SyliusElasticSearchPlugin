Sylius ElasticSearchPlugin
==========================
Elastic search for Sylius.
[![Build status on Linux](https://img.shields.io/travis/Sylius/SyliusElasticSearchPlugin/master.svg)](https://travis-ci.org/Sylius/SyliusElasticSearchPlugin)

## Usage

1. Install it:

    ```bash
    $ composer require sylius/elastic-search-plugin
    ```

2. Install elastic search server:

    ```bash
    $ brew install elasticsearch@5.0
    ```

3. Run elastic search server:

    ```bash
    $ elasticsearch
    ```

4. Add those bundles to `AppKernel.php`:

    ```php
     new \ONGR\ElasticsearchBundle\ONGRElasticsearchBundle(),
     new \SimpleBus\SymfonyBridge\SimpleBusCommandBusBundle(),
     new \SimpleBus\SymfonyBridge\SimpleBusEventBusBundle(),
     new \ONGR\FilterManagerBundle\ONGRFilterManagerBundle(),
     new \Sylius\ElasticSearchPlugin\SyliusElasticSearchPlugin(),
    ```

5. Import config file in `app/config/config.yml` for default filter set configuration:

    ```yaml
    imports:
       - { resource: "@SyliusElasticSearchPlugin/Resources/config/app/config.yml" }
    ```
    For more configuration take a look at [ONGRFilterManager](http://docs.ongr.io/FilterManagerBundle)

6. Configure ONGR bundle in `app/config/config.yml`:

    ```yaml
    ongr_elasticsearch:
        managers:
            default:
                index:
                    index_name: sylius
                mappings:
                    SyliusElasticSearchPlugin: {}

    sylius_elastic_search:
        attribute_whitelist: ['MUG_COLLECTION_CODE', 'MUG_MATERIAL_CODE'] #Only attibutes with these codes will be indexed
    ```

7. Import routing file:

    ```yaml
       sylius_search:
           resource: "@SyliusElasticSearchPlugin/Resources/config/routing.yml"
    ```
8. Create/Setup database:

    ```bash
    $ bin/console ongr:es:index:create
    $ bin/console do:da:cr
    $ bin/console do:sch:cr
    $ bin/console syl:fix:lo
    ```

    If there is a problem with creating elastic search index run those commands:

    ```bash
    $ bin/console ongr:es:index:drop --force
    $ bin/console ongr:es:index:create
    ```
    
9. Example Request/Response:

It's required to pass `channel` argument to the search.
To activate filter you need to pass in parameter (query, request, attribute) ``requested field`` see reference in configuration section.

For e.g:

```
    /shop-api/taxon-products/mugs?channel=WEB_DE&price=2000;3000
```

It will activate ``taxon_slug``, ``price_range`` and ``channel`` filter.

Request:

```
    /shop-api/taxon-products/mugs?channel=WEB_GB
```

<details> 
  <summary>Response:</summary>
  <p>

```json
             {
                 "items": [
                     {
                         "code": "LOGAN_MUG_CODE",
                         "name": "Logan Mug",
                         "slug": "logan-mug",
                         "taxons": [
                             {
                                 "code": "MUG",
                                 "slug": "mugs",
                                 "position": 0,
                                 "images": [],
                                 "description": "@string@"
                             }
                         ],
                         "variants": [
                             {
                                 "code": "LOGAN_MUG_CODE",
                                 "name": "Logan Mug",
                                 "price": {
                                     "current": 1999,
                                     "currency": "GBP"
                                 },
                                 "images": []
                             }
                         ],
                         "attributes": [
                             {
                                 "code": "MUG_COLLECTION_CODE",
                                 "name": "Mug collection",
                                 "value": "HOLIDAY COLLECTION"
                             },
                             {
                                 "code": "MUG_MATERIAL_CODE",
                                 "name": "Mug material",
                                 "value": "Wood"
                             }
                         ],
                         "images": [],
                         "channelCode": "WEB_GB",
                         "localeCode": "en_GB",
                         "mainTaxon": {
                             "code": "MUG",
                             "slug": "mugs",
                             "images": [],
                             "description": "@string@"
                         }
                     },
                     {
                         "code": "LOGAN_MUG_CODE",
                         "name": "Logan Becher",
                         "slug": "logan-becher",
                         "taxons": [
                             {
                                 "code": "MUG",
                                 "slug": "mugs",
                                 "position": 0,
                                 "images": [],
                                 "description": "@string@"
                             }
                         ],
                         "variants": [
                             {
                                 "code": "LOGAN_MUG_CODE",
                                 "name": "Logan Becher",
                                 "price": {
                                     "current": 1999,
                                     "currency": "GBP"
                                 },
                                 "images": []
                             }
                         ],
                         "attributes": [
                             {
                                 "code": "MUG_COLLECTION_CODE",
                                 "name": "Mug collection",
                                 "value": "FEIERTAGSKOLLEKTION"
                             },
                             {
                                 "code": "MUG_MATERIAL_CODE",
                                 "name": "Mug material",
                                 "value": "Holz"
                             }
                         ],
                         "images": [],
                         "channelCode": "WEB_GB",
                         "localeCode": "de_DE",
                         "mainTaxon": {
                             "code": "MUG",
                             "slug": "mugs",
                             "images": [],
                             "description": "@string@"
                         }
                     }
                 ],
                 "filters": {
                     "channel": {
                         "state": {
                             "active": false,
                             "urlParameters": [],
                             "name": "channel",
                             "options": []
                         },
                         "tags": [],
                         "urlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "resetUrlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "name": "channel",
                         "choices": [
                             {
                                 "active": false,
                                 "default": false,
                                 "urlParameters": {
                                     "taxon_slug": "mugs",
                                     "channel": "WEB_GB"
                                 },
                                 "label": "WEB_GB",
                                 "count": 2
                             }
                         ]
                     },
                     "taxon_slug": {
                         "state": {
                             "active": true,
                             "value": "mugs",
                             "urlParameters": {
                                 "taxon_slug": "mugs"
                             },
                             "name": "taxon_slug",
                             "options": []
                         },
                         "tags": [],
                         "urlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "resetUrlParameters": [],
                         "name": "taxon_slug",
                         "choices": [
                             {
                                 "active": true,
                                 "default": false,
                                 "urlParameters": [],
                                 "label": "mugs",
                                 "count": 2
                             },
                             {
                                 "active": false,
                                 "default": false,
                                 "urlParameters": {
                                     "taxon_slug": "t-shirts"
                                 },
                                 "label": "t-shirts",
                                 "count": 2
                             }
                         ]
                     },
                     "price_range": {
                         "state": {
                             "active": false,
                             "urlParameters": [],
                             "name": "price_range",
                             "options": []
                         },
                         "tags": [],
                         "urlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "resetUrlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "name": "price_range",
                         "minBounds": 1999,
                         "maxBounds": 1999
                     },
                     "locale": {
                         "state": {
                             "active": false,
                             "urlParameters": [],
                             "name": "locale",
                             "options": []
                         },
                         "tags": [],
                         "urlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "resetUrlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "name": "locale",
                         "choices": [
                             {
                                 "active": false,
                                 "default": false,
                                 "urlParameters": {
                                     "taxon_slug": "mugs",
                                     "locale_code": "de_DE"
                                 },
                                 "label": "de_DE",
                                 "count": 1
                             },
                             {
                                 "active": false,
                                 "default": false,
                                 "urlParameters": {
                                     "taxon_slug": "mugs",
                                     "locale_code": "en_GB"
                                 },
                                 "label": "en_GB",
                                 "count": 1
                             }
                         ]
                     },
                     "attribute_values": {
                         "state": {
                             "active": false,
                             "urlParameters": [],
                             "name": "attribute_values",
                             "options": []
                         },
                         "tags": [],
                         "urlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "resetUrlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "name": "attribute_values",
                         "choices": [
                             {
                                 "active": false,
                                 "default": false,
                                 "urlParameters": {
                                     "taxon_slug": "mugs",
                                     "attributeValues": [
                                         "FEIERTAGSKOLLEKTION"
                                     ]
                                 },
                                 "label": "FEIERTAGSKOLLEKTION",
                                 "count": 1
                             },
                             {
                                 "active": false,
                                 "default": false,
                                 "urlParameters": {
                                     "taxon_slug": "mugs",
                                     "attributeValues": [
                                         "HOLIDAY COLLECTION"
                                     ]
                                 },
                                 "label": "HOLIDAY COLLECTION",
                                 "count": 1
                             },
                             {
                                 "active": false,
                                 "default": false,
                                 "urlParameters": {
                                     "taxon_slug": "mugs",
                                     "attributeValues": [
                                         "Holz"
                                     ]
                                 },
                                 "label": "Holz",
                                 "count": 1
                             },
                             {
                                 "active": false,
                                 "default": false,
                                 "urlParameters": {
                                     "taxon_slug": "mugs",
                                     "attributeValues": [
                                         "Wood"
                                     ]
                                 },
                                 "label": "Wood",
                                 "count": 1
                             }
                         ]
                     },
                     "paginator": {
                         "state": {
                             "active": false,
                             "value": 1,
                             "urlParameters": [],
                             "name": "paginator",
                             "options": []
                         },
                         "tags": [],
                         "urlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "resetUrlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "name": "paginator",
                         "currentPage": 1,
                         "totalItems": 2,
                         "maxPages": 10,
                         "itemsPerPage": 10,
                         "numPages": 1,
                         "options": []
                     },
                     "search": {
                         "state": {
                             "active": false,
                             "urlParameters": [],
                             "name": "search",
                             "options": []
                         },
                         "tags": [],
                         "urlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "resetUrlParameters": {
                             "taxon_slug": "mugs"
                         },
                         "name": "search"
                     }
                 }
             }
``` 
  </p>
</details>
<br />
10. Filtering by attributes:

You need use attributes query parameter which is an associative array where key is the attribute name and value is an array of attribute values.
For e.g:
```php
$this->client->request('GET', '/shop-api/products', ['attributes' => ['Mug material' => ['Wood']]], [], ['ACCEPT' => 'application/json']);
```

This filter also aggregates all attribute values and it will group them by attribute name


<details> 
  <summary>Aggregation response from this request:</summary>
  <p>

```json
  "attributes":{
      "state":{
        "active":true,
        "value":{
          "Mug material":[
            "Wood"
          ]
        },
        "urlParameters":{
          "attributes":{
            "Mug material":[
              "Wood"
            ]
          }
        },
        "name":"attributes",
        "options":[

        ]
      },
      "tags":[

      ],
      "urlParameters":{
        "attributes":{
          "Mug material":[
            "Wood"
          ]
        }
      },
      "resetUrlParameters":[

      ],
      "name":"attributes",
      "items":[
        {
          "tags":[

          ],
          "urlParameters":[

          ],
          "resetUrlParameters":[

          ],
          "name":"Mug collection",
          "choices":{
            "HOLIDAY COLLECTION":{
              "active":false,
              "default":false,
              "urlParameters":{
                "attributes":{
                  "Mug material":[
                    "Wood"
                  ],
                  "Mug collection":[
                    "HOLIDAY COLLECTION"
                  ]
                }
              },
              "label":"HOLIDAY COLLECTION",
              "count":1
            }
          }
        },
        {
          "tags":[

          ],
          "urlParameters":[

          ],
          "resetUrlParameters":[

          ],
          "name":"Mug material",
          "choices":{
            "Holz":{
              "active":false,
              "default":false,
              "urlParameters":{
                "attributes":{
                  "Mug material":[
                    "Wood",
                    "Holz"
                  ]
                }
              },
              "label":"Holz",
              "count":1
            },
            "Wood":{
              "active":true,
              "default":false,
              "urlParameters":{
                "attributes":{
                  "Mug material":[

                  ]
                }
              },
              "label":"Wood",
              "count":1
            }
          }
        }
      ]
    }
```
  </p>
</details>
<br />
You can combine filters so for example if you want your products to be filtered in specific locale you can add another query parameter

Example request with locale:
```php
$this->client->request('GET', '/shop-api/products', ['attributes' => ['Mug material' => ['Wood']], 'locale' => 'en_GB'], [], ['ACCEPT' => 'application/json']);
```

<details> 
  <summary>Aggregation response from this request:</summary>
  <p>

```json
  "attributes":{  
         "state":{  
            "active":true,
            "value":{  
               "Mug material":[  
                  "Wood"
               ]
            },
            "urlParameters":{  
               "attributes":{  
                  "Mug material":[  
                     "Wood"
                  ]
               }
            },
            "name":"attributes",
            "options":[  

            ]
         },
         "tags":[  

         ],
         "urlParameters":{  
            "locale":"en_GB",
            "attributes":{  
               "Mug material":[  
                  "Wood"
               ]
            }
         },
         "resetUrlParameters":{  
            "locale":"en_GB"
         },
         "name":"attributes",
         "items":[  
            {  
               "tags":[  

               ],
               "urlParameters":[  

               ],
               "resetUrlParameters":{  
                  "locale":"en_GB"
               },
               "name":"Mug collection",
               "choices":{  
                  "HOLIDAY COLLECTION":{  
                     "active":false,
                     "default":false,
                     "urlParameters":{  
                        "locale":"en_GB",
                        "attributes":{  
                           "Mug material":[  
                              "Wood"
                           ],
                           "Mug collection":[  
                              "HOLIDAY COLLECTION"
                           ]
                        }
                     },
                     "label":"HOLIDAY COLLECTION",
                     "count":1
                  }
               }
            },
            {  
               "tags":[  

               ],
               "urlParameters":[  

               ],
               "resetUrlParameters":{  
                  "locale":"en_GB"
               },
               "name":"Mug material",
               "choices":{  
                  "Wood":{  
                     "active":true,
                     "default":false,
                     "urlParameters":{  
                        "locale":"en_GB",
                        "attributes":{  
                           "Mug material":[  

                           ]
                        }
                     },
                     "label":"Wood",
                     "count":1
                  }
               }
            }
         ]
      }
```
  </p>
</details>
<br />
<details> 
  <summary>Whole response:</summary>
  <p>

```json
{
   "items":[
      {
         "code":"LOGAN_MUG_CODE",
         "name":"Logan Mug",
         "slug":"logan-mug",
         "taxons":{
            "main":"MUG",
            "others":[
               "MUG",
               "CATEGORY",
               "BRAND"
            ]
         },
         "variants":[
            {
               "code":"LOGAN_MUG_CODE",
               "name":"Logan Mug",
               "price":{
                  "current":1999,
                  "currency":"GBP"
               },
               "images":[

               ]
            }
         ],
         "attributes":[
            {
               "code":"MUG_COLLECTION_CODE",
               "name":"Mug collection",
               "value":"HOLIDAY COLLECTION"
            },
            {
               "code":"MUG_MATERIAL_CODE",
               "name":"Mug material",
               "value":"Wood"
            }
         ],
         "images":[

         ],
         "channelCode":"WEB_GB",
         "localeCode":"en_GB"
      }
   ],
   "filters":{
      "channel":{
         "state":{
            "active":false,
            "urlParameters":[

            ],
            "name":"channel",
            "options":[

            ]
         },
         "tags":[

         ],
         "urlParameters":{
            "locale":"en_GB",
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "resetUrlParameters":{
            "locale":"en_GB",
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "name":"channel",
         "choices":[
            {
               "active":false,
               "default":false,
               "urlParameters":{
                  "locale":"en_GB",
                  "attributes":{
                     "Mug material":[
                        "Wood"
                     ]
                  },
                  "channel":"WEB_GB"
               },
               "label":"WEB_GB",
               "count":1
            }
         ]
      },
      "taxon_code":{
         "state":{
            "active":false,
            "urlParameters":[

            ],
            "name":"taxon_code",
            "options":[

            ]
         },
         "tags":[

         ],
         "urlParameters":{
            "locale":"en_GB",
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "resetUrlParameters":{
            "locale":"en_GB",
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "name":"taxon_code",
         "choices":[
            {
               "active":false,
               "default":false,
               "urlParameters":{
                  "locale":"en_GB",
                  "attributes":{
                     "Mug material":[
                        "Wood"
                     ]
                  },
                  "taxonCode":"BRAND"
               },
               "label":"BRAND",
               "count":1
            },
            {
               "active":false,
               "default":false,
               "urlParameters":{
                  "locale":"en_GB",
                  "attributes":{
                     "Mug material":[
                        "Wood"
                     ]
                  },
                  "taxonCode":"CATEGORY"
               },
               "label":"CATEGORY",
               "count":1
            },
            {
               "active":false,
               "default":false,
               "urlParameters":{
                  "locale":"en_GB",
                  "attributes":{
                     "Mug material":[
                        "Wood"
                     ]
                  },
                  "taxonCode":"MUG"
               },
               "label":"MUG",
               "count":1
            }
         ]
      },
      "price_range":{
         "state":{
            "active":false,
            "urlParameters":[

            ],
            "name":"price_range",
            "options":[

            ]
         },
         "tags":[

         ],
         "urlParameters":{
            "locale":"en_GB",
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "resetUrlParameters":{
            "locale":"en_GB",
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "name":"price_range",
         "minBounds":1999,
         "maxBounds":2999
      },
      "locale":{
         "state":{
            "active":true,
            "value":"en_GB",
            "urlParameters":{
               "locale":"en_GB"
            },
            "name":"locale",
            "options":[

            ]
         },
         "tags":[

         ],
         "urlParameters":{
            "locale":"en_GB",
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "resetUrlParameters":{
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "name":"locale",
         "choices":[
            {
               "active":true,
               "default":false,
               "urlParameters":{
                  "attributes":{
                     "Mug material":[
                        "Wood"
                     ]
                  }
               },
               "label":"en_GB",
               "count":1
            }
         ]
      },
      "paginator":{
         "state":{
            "active":false,
            "value":1,
            "urlParameters":[

            ],
            "name":"paginator",
            "options":[

            ]
         },
         "tags":[

         ],
         "urlParameters":{
            "locale":"en_GB",
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "resetUrlParameters":{
            "locale":"en_GB",
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "name":"paginator",
         "currentPage":1,
         "totalItems":1,
         "maxPages":10,
         "itemsPerPage":10,
         "numPages":1,
         "options":[

         ]
      },
      "search":{
         "state":{
            "active":false,
            "urlParameters":[

            ],
            "name":"search",
            "options":[

            ]
         },
         "tags":[

         ],
         "urlParameters":{
            "locale":"en_GB",
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "resetUrlParameters":{
            "locale":"en_GB",
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "name":"search"
      },
      "attributes":{
         "state":{
            "active":true,
            "value":{
               "Mug material":[
                  "Wood"
               ]
            },
            "urlParameters":{
               "attributes":{
                  "Mug material":[
                     "Wood"
                  ]
               }
            },
            "name":"attributes",
            "options":[

            ]
         },
         "tags":[

         ],
         "urlParameters":{
            "locale":"en_GB",
            "attributes":{
               "Mug material":[
                  "Wood"
               ]
            }
         },
         "resetUrlParameters":{
            "locale":"en_GB"
         },
         "name":"attributes",
         "items":[
            {
               "tags":[

               ],
               "urlParameters":[

               ],
               "resetUrlParameters":{
                  "locale":"en_GB"
               },
               "name":"Mug collection",
               "choices":{
                  "HOLIDAY COLLECTION":{
                     "active":false,
                     "default":false,
                     "urlParameters":{
                        "locale":"en_GB",
                        "attributes":{
                           "Mug material":[
                              "Wood"
                           ],
                           "Mug collection":[
                              "HOLIDAY COLLECTION"
                           ]
                        }
                     },
                     "label":"HOLIDAY COLLECTION",
                     "count":1
                  }
               }
            },
            {
               "tags":[

               ],
               "urlParameters":[

               ],
               "resetUrlParameters":{
                  "locale":"en_GB"
               },
               "name":"Mug material",
               "choices":{
                  "Wood":{
                     "active":true,
                     "default":false,
                     "urlParameters":{
                        "locale":"en_GB",
                        "attributes":{
                           "Mug material":[

                           ]
                        }
                     },
                     "label":"Wood",
                     "count":1
                  }
               }
            }
         ]
      }
   }
}
```
  </p>
</details>
<br />
11. Sorting

* By name ascending:

    ```
        /shop-api/products?channel=WEB_DE&sort[name]=asc
    ```
    
* By price descending:

    ```
        /shop-api/products?channel=WEB_DE&sort[price]=desc
    ```
    
* By attribute `ATTRIBUTE_CODE` ascending:

    ```
        /shop-api/products?channel=WEB_DE&sort[attributes][ATTRIBUTE_CODE]=asc
    ```
    
* By price ascending, then by name descending:
    
    ```
        /shop-api/products?channel=WEB_DE&sort[price]=asc&sort[name]=desc
    ```

12. Filtering by attribute

* By attribute name and value:

    ```
        /shop-api/products?channel=WEB_DE&attributes[Attribute name]=value
    ```
    
* By attribute code and value:
    
    ```
        /shop-api/products?channel=WEB_DE&attributesByCode[ATTRIBUTE_CODE]=value
    ```

13. Reindexing Elasticsearch

The current implementation does not support updating Elasticsearch when an entity is updated.
In order to stay up-to-date, run the following command:

    ```
        bin/console sylius:elastic-search:update-product-index
    ```

If you want to recreate the index, run (it will drop it):

    ```
        bin/console sylius:elastic-search:reset-product-index
    ```
