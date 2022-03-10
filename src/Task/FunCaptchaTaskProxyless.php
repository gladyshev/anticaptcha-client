<?php

namespace Anticaptcha\Task;

class FunCaptchaTaskProxyless extends AbstractTask
{
    /*
     * Address of a target web page. Can be located anywhere on the web site, even in a member area. Our workers don't
     * navigate there but simulate the visit instead.
     */
    public string $websiteURL;

    /*
     * Arkose Labs public key
     */
    public string $websitePublicKey;

    /*
     * Custom Arkose Labs subdomain from which the Javascript widget is loaded. Required for some cases, but most
     * Arkose Labs integrations run without it.
     */
    public ?string $funcaptchaApiJSSubdomain = null;

    /*
     * An additional parameter that may be required by Arkose Labs implementation. Use this property to send "blob"
     * value as an object converted to a string. See an example of what it might look like.
     * {"\blob\":\"HERE_COMES_THE_blob_VALUE\"}
     */
    public ?string $data = null;
}
