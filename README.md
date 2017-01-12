## About Beacon Bacon

Beacon Bacon is an indoor map & wayfinding platform build on Laravel Framework.

Beacon Bacon consists of an administation interface to create **places**, **floors** and **point of interests**, and an API to consume all of this in a nice mobile app or web page - which you need to code yourself. :-)

The Beacon Bacon administration interface gives the administrator all the neccessary options of creating and placing artifacts unto maps with a specified centimeter-to-pixel ratio. The specific maps have to be uploaded as jpeg or png files when creating **floors**. The uploaded images should correspond to a real world floor plan and it is up to the administrator to upload as fitting a floor plan as possible. A **floor** is basically a child of a **place** and can not live on its own. 

The main artifact in addition to **floors** and **places** are the **beacons**. These will be added by the administrator and should correspond to where they have been placed in real life. The real life placement and the Beacon Bacon placement should match as much as possible, but of course that is not 100 % possible and will have a margin of error. 

An example of a setup, could be a museum (**place**) containing a building 1 (**floor 1**) and a building 2 (**floor 2**). Each virtual building has an uploaded floor plan, that visualizes the walls, corners and restricted areas of that physical real life building. In each physical building, around 25 **beacons** will be placed and will be entered into the Beacon Bacon application unto the floor plan. In addition to the **beacons**, 15 **points of interest** and 15 **blocks** will also be places unto the map.  

Read more on [beaconbacon.io](https://beaconbacon.io) (Currently under development.)

## API Documentation

The API (V1) documentation can be found [here](https://documenter.getpostman.com/view/918890/beacon-bacon-api-v1-documentation/2SJVeB). Documentation is currently being updated - any found typos and errors can be directed at webmaster@nosuchagency.dk.

## Practical Example

Our good friends [Mustache](http://mustache.dk/) has created an iOS app using Beacon Bacon, and put it on GitHub. It's not a SDK, but it's a very good start. Find it [here](https://github.com/mustachedk/beacon-bacon-ios). 

## Security Vulnerabilities

If you discover a security vulnerability within Beacon Bacon, please send an e-mail to us at webmaster@nosuchagency.dk. All security vulnerabilities will be promptly addressed.


## Contributing

Beacon Bacon is still in early development, so we have not yet developed a Contribution Guide. Pull request is always welcome.

## License

Beacon Bacon, as Laravel, is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
