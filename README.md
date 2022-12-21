# phalcon-bug

## Steps to reproduce

```
git clone https://github.com/madrian-es/phalcon-bug.git
cd phalcon-bug
docker-compose up
```

This will build a docker image with PHP 8.1.13 and Phalcon 5.1.2 using the dockerfile in `docker/php`. After the build finishes, the nginx proxy should be available on port 8080. Then, run the following:

```
curl --request POST \
  --url http://localhost:8080/api/token \
  --header 'Content-Type: multipart/form-data' \
  --form token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.bXcvwBlJO9IEGMJ5bn3Faz2_4I0HoK6FUj5pAkrr3iw
```

This should produce the following output:

```
json_decode error: Syntax error
#0 [internal function]: Phalcon\Encryption\Security\JWT\Token\Parser->decode('{"alg":"HS256",...', true)
#1 [internal function]: Phalcon\Encryption\Security\JWT\Token\Parser->decodeHeaders('eyJhbGciOiJIUzI...')
#2 /code/webinterface/app/library/Jwt.php(33): Phalcon\Encryption\Security\JWT\Token\Parser->parse('eyJhbGciOiJIUzI...')
#3 /code/webinterface/app/controllers/Api/TokenController.php(28): App\Jwt->isValidJWT('eyJhbGciOiJIUzI...')
#4 [internal function]: App\Controllers\Api\TokenController->parseTokenAction()
#5 [internal function]: Phalcon\Dispatcher\AbstractDispatcher->callActionMethod(Object(App\Controllers\Api\TokenController), 'parseTokenActio...', Array)
#6 [internal function]: Phalcon\Dispatcher\AbstractDispatcher->dispatch()
#7 /code/webinterface/public/index.php(24): Phalcon\Mvc\Application->handle('/api/token')
#8 {main}
```

If line `52` in `app/controllers/ApiBase.php` is uncommented, the output will be:

```
It worked
```

This is happening because `$this->request->getJsonRawBody()` sets the `json_last_error()` to a value different than 0, but this value is NOT reset when the JWT parser decodes the JWT header.