# http-echo

## What is this project
This project is used for telling the details of your http requests. 

## Demo address
[https://echo.jeek.club](https://echo.jeek.club) or [http://echo.jeek.club](http://echo.jeek.club)

## Usage
Just try to request the demo address. 
For example: 
  $ curl "https://echo.jeek.club/this-is-path?query-a=hello&query-b=echo"
  $ curl -X POST "https://echo.jeek.club/this-is-path?query-a=hello&query-b=echo" -d 'key-a=1&key-b=bonjour'
  $ curl -X POST "https://echo.jeek.club/this-is-path?query-a=hello&query-b=echo" -H "Content-Type: application/json" -d '{"key-a": 1, "key-b": "bonjour"}'
Result: 
'''
  {
    "method": "POST",
    "path": "this-is-path",
    "headers": {
        "Accept-Encoding": "gzip",
        "X-Real-Ip": "117.85.25.111",
        "X-Forwarded-Proto": "https",
        "X-Forwarded-For": "117.85.25.111",
        "Content-Type": "application/json",
        "Accept": "*/*",
        "Content-Length": "32",
        "User-Agent": "curl/7.54.0",
        "Host": "echo.jeek.club"
    },
    "accept": "*/*",
    "params": {
        "key-a": 1,
        "key-b": "bonjour",
        "query-a": "hello",
        "query-b": "echo"
    },
    "content-type": "application/json",
    "content-length": "32",
    "body": "{\"key-a\": 1, \"key-b\": \"bonjour\"}",
    "bodyPretty": {
        "key-a": 1,
        "key-b": "bonjour"
    },
    "query": "query-a=hello&query-b=echo",
    "queryPretty": {
        "query-a": "hello",
        "query-b": "echo"
    }
  }
  '''
  
## Build and run it on :8081
  $ docker-compose up -d
