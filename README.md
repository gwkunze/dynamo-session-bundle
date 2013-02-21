# DynamoDb Session Handler bundle #

This Symfony 2.1 bundle allows you to use the DynamoDb Web Service to store your sessions

Installation
============

Simply add the following to your composer.json file

```js
{
    "require": {
        "gwk/dynamo-session-bundle": "0.*"
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
    read_capacity: 10 # Default read capacity
    write_capacity: 10 # Default write capacity
    aws:
        region: us-east-1 # AWS Region to use
        key: AKA123456789 # Your AWS key
        secret: abcdeffhij # Your AWS secret
```

If you use AWS IAM Roles and your instance's permissions allow access to the appropriate DynamoDb Table you can leave out the credentials.

If the table does not exist the bundle will create the table for you with the specified capacities. Once the table is created the capacity configuration values are no longer used (unless the table is deleted).

License
=======

MIT, See LICENSE

