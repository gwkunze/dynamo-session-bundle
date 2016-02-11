# DynamoDb Session Handler bundle #

This Symfony 2.x bundle allows you to use the DynamoDb Web Service to store your sessions

__Starting from version 1.0 this bundle requires the AWS PHP SDK version 3.0+, if you're using the 2.x SDK use the latest 0.x version__

Installation
============

Simply add the following to your composer.json file

```js
{
    "require": {
        "gwk/dynamo-session-bundle": "1.*"
    }
}
```

And use composer to install the bundle:
```
composer.phar update gwk/dynamo-session-bundle
```

Now add the bundle to your app/AppKernel.php:

```php
$bundles[] = new GWK\DynamoSessionBundle\GWKDynamoSessionBundle();
```

Configuration
=============

Add the following configuration setting to your app/config/config.yml

```yaml
framework:
    session:
        handler_id: dynamo_session_handler

gwk_dynamo_session:
    table: my_session_table # DynamoDb Table to store sessions in
    locking_strategy: pessimistic # See AWS PHP documentation for valid values
    # dynamo_client_id: my_dynamodb_service # If you already use DynamoDb and you have a AWS\DynamoDb\DynamoDbClient service, you can make the session handler use it
    automatic_gc: true # Whether to use PHP's internal automatic garbage collection. The AWS sdk doesn't recommend it but doesn't explain why
    gc_batch_size: 25 # Maximum number of sessions the garbage collector deletes when garbage collection is started (manually or automatic)
    session_lifetime: 3600 # Number of seconds after which idle sessions should be garbage collected
    read_capacity: 10 # Default read capacity
    write_capacity: 10 # Default write capacity
    aws:
        region: us-east-1 # AWS Region to use
        version: latest # AWS API version
        credentials:
            key: AKA123456789 # Your AWS key
            secret: abcdeffhij # Your AWS secret
```

If you use AWS IAM Roles and your instance's permissions allow access to the appropriate DynamoDb Table you can leave out the credentials.

If the table does not exist the bundle will create the table for you with the specified capacities. Once the table is created the capacity configuration values are no longer used (unless the table is deleted).

FAQ
===

Fixing cURL error #77
---------------------
Certain versions of CentOS AWS AMIs may need this additional php.ini configuration to fix this exception:

```
curl.cainfo="/etc/ssl/certs/ca-bundle.crt" 
```

Source: http://stackoverflow.com/a/26269489

License
=======

MIT, See LICENSE

