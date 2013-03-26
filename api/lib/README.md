#CloudFlare API PHP Binding


This is a basic PHP binding for the [CloudFlare](https://www.cloudflare.com/) [Client](https://www.cloudflare.com/docs/client-api.html) and [Host](https://www.cloudflare.com/docs/host-api.html) APIs.

Depending on the number of parameters passed, you can use either the host functions, or the client functions.

A PHP object is returned in all cases.


##Client API

###Usage

    $cf = new cloudflare_api("me@example.com", "799df833d7a42adf3b8e2fd113c7260b955b8e95ac42c");
    $response = $cf->stats("example.com", INTERVAL_30_DAYS);
    
	
##Host API

###Usage

    $cf = new cloudflare_api("8afbe6dea02407989af4dd4c97bb6e25");
    $response = $cf->user_create("newuser@example.com", "newpassword", "", "someuniqueid");
