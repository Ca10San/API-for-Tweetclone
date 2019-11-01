# Tweetclone API

## Intro

I'm now applying my current knowledge with **PHP**, in this API, build with [**Lumen Framework**](https://lumen.laravel.com/).

## Objective

This project will be the backend for my another project, an simple app that mimetizes Twitter (will be pushed soon).

## How this works?

Works like any other API accepts: GET, POST, DELETE and UPDATE methods

## Commands

**First things first**
### Registering into API

#### Request

You will need to send via **POST** method: **admin**, **pass** and **nome** to register

```
{
    URL : ''**www.myapp.com/users/register**'',
    Method : ''POST'',
    Headers : new Headers{
        admin : ''**your email**'',
        pass : ''**your password**'',
        name : ''**your nickname**''
    }
}
```

#### Response

If success
```
{
    Status : OK,
    Token : 9abf9cd286df39c9687d26fc95d75a61
}
```

If something go wrong
```
{
    Status : ERROR,
    ERROR : Some explanation here about the error
}
```

### Login

#### Request
Get yout token using **GET** method, **admin** and **pass** Headers, like this:

```
{
    URL : ''**www.myapp.com/token**'',
    Method : ''GET'',
    Headers : new Headers{
        admin : ''**your email**'',
        pass : ''**your password**''
    }
}
```

#### Response
This will return your **Token** (in JSON)  to access the functionalities of API

```
    {
        token : 9abf9cd286df39c9687d26fc95d75a61
    }
```

##### Important!
Send your token in a header of all others Requests

```
{
    URL : ''**www.myapp.com/anyrequest**'',
    Method : ''GET'',
    Headers : new Headers{
        token : 9abf9cd286df39c9687d26fc95d75a61,
        otherheader : any other data,
        otherheader2 : any other data2
    }
}
```

