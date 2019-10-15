# Tweetclone API

## Intro

I'm now applying my current knowledge with **PHP**, in this API, build with **Lumen Framework**.

## Objective

This project will be the backend for my another project, an simple app that mimetizes Twitter (will be pushed soon).

## How this works?

Works like any other API, accepts, GET, POST, DELETE and UPDATE methods

## Commands
### Login

Using **GET** method, **admin** and **pass** Headers, like this:

{
    URL : ''**www.myapp.com/token**'',
    Method : ''GET'',
    Haders : new Headers{
        admin : ''**your email**'',
        pass : ''**your password**''
    }
}

This will return your **Token** (in JSON) to access the functionalities of API