<?php

namespace Diag\Patient\ElasticSearch\Providers;

use Diag\Patient\ElasticSearch\ElasticSearch;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class ElasticSearchServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ElasticSearch::class, function ($app) {
            return new ElasticSearch(ClientBuilder::create()
                ->setHosts([config('elasticsearch.connection.host')])
                ->setSSLVerification(false)
                ->setBasicAuthentication(
                    config('elasticsearch.connection.user'),
                    config('elasticsearch.connection.pass')
                )
                ->build());
        });
    }
}
