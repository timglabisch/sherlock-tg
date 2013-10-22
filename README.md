Improvements to Sherlock
========

Sherlock is a lib to communicate with Elasticsarch.
This Project extends Sherlock to allow some advanced stuff.

Raw Query Support
--------

```php
    use \Tg\Sherlock;


    //The Sherlock object manages cluster state, builds queries, etc
    $sherlock = new Sherlock();

    //Add a node to our cluster.  Sherlock can optionally autodetect nodes given one starting seed
    $sherlock->addNode('localhost', 9200);

    //Build a new search request
    $request = $sherlock->_raw();

    //Set the index, type and from/to parameters of the request.
    //The query is at the end of the chain, although it could be placed anywhere

    $request->index("test")
        ->type("tweet")
        ->from(0)
        ->size(10)
        ->raw(
            array('foo' => 'bar') // this is a raw query
        );
```