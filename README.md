# Exml

A simple XML parser that converts XML to an object regardless of namespace.
This package use

## Installation

This package can be installed via composer/packagist

```composer require domattr/exml```

## Usage

To read and parse XML we simply use the read() method

```php
$xml = '<?xml version="1.0" encoding="utf-8?><Customer><Name>Matt</Name></Customer';

$obj = Domattr\Exml\Exml::read($xml);
```


### Using the Object

The returned object will contain all data, attributes & children.
Below is a simple example of the raw XML and resulting object:

```xml
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
        <github:Repo>
            <RepoName>Exml</RepoName>
            <UserInformation>
                <Name>Matt Lake</Name>
                <Role>Developer</Role>
            </UserInformation>
            <Url>https://github.com/mattlake/exml</Url>
            <Status>Public</Status>
        </github:Repo>
    </soap:Body>
</soap:Envelope>
```

```php
object(Domattr\Exml\Container)#4 (7) {
  ["version":"Domattr\Exml\Container":private]=>
  string(3) "1.0"
  ["encoding":"Domattr\Exml\Container":private]=>
  string(5) "utf-8"
  ["namespace":"Domattr\Exml\Element":private]=>
  string(4) "soap"
  ["tag":"Domattr\Exml\Element":private]=>
  string(8) "Envelope"
  ["attributes":"Domattr\Exml\Element":private]=>
  array(3) {
    [0]=>
    object(Domattr\Exml\Attribute)#5 (2) {
      ["key":"Domattr\Exml\Attribute":private]=>
      string(9) "xmlns:xsi"
      ["value":"Domattr\Exml\Attribute":private]=>
      string(41) "http://www.w3.org/2001/XMLSchema-instance"
    }
    [1]=>
    object(Domattr\Exml\Attribute)#6 (2) {
      ["key":"Domattr\Exml\Attribute":private]=>
      string(9) "xmlns:xsd"
      ["value":"Domattr\Exml\Attribute":private]=>
      string(32) "http://www.w3.org/2001/XMLSchema"
    }
    [2]=>
    object(Domattr\Exml\Attribute)#7 (2) {
      ["key":"Domattr\Exml\Attribute":private]=>
      string(10) "xmlns:soap"
      ["value":"Domattr\Exml\Attribute":private]=>
      string(41) "http://schemas.xmlsoap.org/soap/envelope/"
    }
  }
  ["children":"Domattr\Exml\Element":private]=>
  array(1) {
    ["Body"]=>
    object(Domattr\Exml\Element)#9 (5) {
      ["namespace":"Domattr\Exml\Element":private]=>
      string(4) "soap"
      ["tag":"Domattr\Exml\Element":private]=>
      string(4) "Body"
      ["attributes":"Domattr\Exml\Element":private]=>
      array(0) {
      }
      ["children":"Domattr\Exml\Element":private]=>
      array(1) {
        ["Repo"]=>
        object(Domattr\Exml\Element)#11 (5) {
          ["namespace":"Domattr\Exml\Element":private]=>
          string(6) "github"
          ["tag":"Domattr\Exml\Element":private]=>
          string(4) "Repo"
          ["attributes":"Domattr\Exml\Element":private]=>
          array(0) {
          }
          ["children":"Domattr\Exml\Element":private]=>
          array(4) {
            ["RepoName"]=>
            object(Domattr\Exml\Element)#16 (5) {
              ["namespace":"Domattr\Exml\Element":private]=>
              NULL
              ["tag":"Domattr\Exml\Element":private]=>
              string(8) "RepoName"
              ["attributes":"Domattr\Exml\Element":private]=>
              array(0) {
              }
              ["children":"Domattr\Exml\Element":private]=>
              array(0) {
              }
              ["value":"Domattr\Exml\Element":private]=>
              string(4) "Exml"
            }
            ["UserInformation"]=>
            object(Domattr\Exml\Element)#17 (5) {
              ["namespace":"Domattr\Exml\Element":private]=>
              NULL
              ["tag":"Domattr\Exml\Element":private]=>
              string(15) "UserInformation"
              ["attributes":"Domattr\Exml\Element":private]=>
              array(0) {
              }
              ["children":"Domattr\Exml\Element":private]=>
              array(2) {
                ["Name"]=>
                object(Domattr\Exml\Element)#20 (5) {
                  ["namespace":"Domattr\Exml\Element":private]=>
                  NULL
                  ["tag":"Domattr\Exml\Element":private]=>
                  string(4) "Name"
                  ["attributes":"Domattr\Exml\Element":private]=>
                  array(0) {
                  }
                  ["children":"Domattr\Exml\Element":private]=>
                  array(0) {
                  }
                  ["value":"Domattr\Exml\Element":private]=>
                  string(9) "Matt Lake"
                }
                ["Role"]=>
                object(Domattr\Exml\Element)#21 (5) {
                  ["namespace":"Domattr\Exml\Element":private]=>
                  NULL
                  ["tag":"Domattr\Exml\Element":private]=>
                  string(4) "Role"
                  ["attributes":"Domattr\Exml\Element":private]=>
                  array(0) {
                  }
                  ["children":"Domattr\Exml\Element":private]=>
                  array(0) {
                  }
                  ["value":"Domattr\Exml\Element":private]=>
                  string(9) "Developer"
                }
              }
              ["value":"Domattr\Exml\Element":private]=>
              NULL
            }
            ["Url"]=>
            object(Domattr\Exml\Element)#19 (5) {
              ["namespace":"Domattr\Exml\Element":private]=>
              NULL
              ["tag":"Domattr\Exml\Element":private]=>
              string(3) "Url"
              ["attributes":"Domattr\Exml\Element":private]=>
              array(0) {
              }
              ["children":"Domattr\Exml\Element":private]=>
              array(0) {
              }
              ["value":"Domattr\Exml\Element":private]=>
              string(32) "https://github.com/mattlake/exml"
            }
            ["Status"]=>
            object(Domattr\Exml\Element)#18 (5) {
              ["namespace":"Domattr\Exml\Element":private]=>
              NULL
              ["tag":"Domattr\Exml\Element":private]=>
              string(6) "Status"
              ["attributes":"Domattr\Exml\Element":private]=>
              array(0) {
              }
              ["children":"Domattr\Exml\Element":private]=>
              array(0) {
              }
              ["value":"Domattr\Exml\Element":private]=>
              string(6) "Public"
            }
          }
          ["value":"Domattr\Exml\Element":private]=>
          NULL
        }
      }
      ["value":"Domattr\Exml\Element":private]=>
      NULL
    }
  }
  ["value":"Domattr\Exml\Element":private]=>
  NULL
}
```

### Using the object

The data within the object can be accessed like so:
```php
$obj = Exml::read($xml);

// Get the username
$username = $obj->Body->Repo->UserInformation->Name->value();


```

