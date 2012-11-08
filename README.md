[POC] Accepting EcoCash Payments Online
=======

So we got more attention than we vouched for from developers who wanted to try out the payment--which isn't a bad thing :)--and we put together simple DEMO SDK for the developers.

## Clearing some issues
The TZ article was slightly misleading. This isn't an open-source project, what they meant to say was we would put the libraries/SDK on GitHub for developers and webmasters to try. The Open Source parts of it are the integrations for Wordpress, Joomla and other helper libraries we are working on-not the core of the system.

Then on the "legality" of this. I'm not sure where we are treading into someone'e house so to speak. Before now, you'd fill a form on a website, get an order number, transfer funds, claim your order by sending your approval code over email/call a website's support/sales. So instead of that email, your phone now reads the code, matches it with the orders database and does whatever has to be done after. I'm sure the term hack made some to think we found a way into EcoCash servers and are now funneling data from it. Oh, and Econet makes money off every transaction you make in case you thought we hacked that too :D

### Updates/Questions
Just created https://groups.google.com/d/forum/helpingzimstartups

## About the Alpha Demo SDK
The DEMO SDK is to help you understand and get started. It routes transfers to our servers which then forward to your server as will be explained below. It lacks much of the functionality of the final. Things such as backing-up data, exporting the databases, reconciling the SMS inbox and the application's database say after a system failure and cleaning the displayed data to keep the applcation performing as fast as it should. It adds administrative tasks, auditing tasks, collects more data about the transaction (phone number) and has disaster recovery. The DEMO one works just as well, it only lacks these house-keeping functionalities and some data about a transaction.

### Updates
We're setting up a mailing list for the developers

## Setting things up (Developers only)
The SDk has 3 files. A PHP file, an Android Application and an SQL file. You have to import the SQL file into your database. The other configurations are explained in the index.php file.

The critical things you need from us are a Merchant Key & a Secret Key. Email to sam.takunda@gmail.com with subject "Request For API Access" to get these which are unique to you. The Secret Key should never be displayed in any way or shared in any way on your website. Our DEMO API uses a REST interface and authenticates using these keys and SHA265 HASH digests. You also need to put the index.php in a location on your website which you give to use when requesting API keys, preferrably in its own folder so that the url is along the lines of http://example.com/whatevercallbackyou/choose

You then install the Android APK on an Android Device which is fast, has reasonable free storage and is on a fast network such as your secured home/work WiFi. In the menu select preferences and here you input your API keys and check the "Enable Submissions" option when you are ready to communicate with our servers.

The reason mobile banking providers worldwide offer merchant numbers is to mask away the phone number that receives the funds because once it is known you can get fake transfers from a novice user. The DEMO looks out for transfer messages without considering the origin they are from. This is to help you test.

Also make sure your url is valid. When our server receives a transfer it attempts there and then to route it to yours, if that fails (timeout maybe) there's a separate daemon that keeps retrying but at the moment we've put that daemon down because all so far have gone through. It's your responsibilty with this DEMO to make sure you're connected.

### Known Issues
The DEMO doesn't force times to our timezone, so it depends on your device.
