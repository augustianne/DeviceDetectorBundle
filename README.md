# DeviceDetectorBundle

Symfony2 Bundle for switching controllers for different device views. This caters to adaptive websites with two different controller for mobile and desktop views.

__Sample Configuration__

__1. Simple desktop to mobile controller redirect.__ 

This will render th mobile view for tablets as well.

```
device_detector:
    mobile:
        enabled: true
        controllers:
            -
                from_controller_path: 'Acme\MainBundle\Controller\Frontend'
                to_controller_path: 'Acme\MainBundle\Controller\MobileFrontend'
                routes:
                    - 'acme_frontend_homepage'
                    - 'acme_frontend_news'
                    - 'acme_frontend_about_us'
```

__2. Simple desktop to mobile redirection but render desktop view for tablets.__

```
device_detector:
    tablet:
        treat_as_mobile: false
        controllers: []
    mobile:
        enabled: true
        controllers:
            -
                from_controller_path: 'Acme\MainBundle\Controller\Frontend'
                to_controller_path: 'Acme\MainBundle\Controller\MobileFrontend'
                routes:
                    - 'acme_frontend_homepage'
                    - 'acme_frontend_news'
                    - 'acme_frontend_about_us'
```

__3. Simple desktop to tablet controller redirect.__ 

By default, the bundle will treat tablets as mobile devices and will follow the configuration for mobile redirection, so it is important to set ```treat_as_mobile``` to false when tablet redirection is enabled.

```
device_detector:
    tablet:
        enabled: true
        treat_as_mobile: false
        controllers:
            -
                from_controller_path: 'Acme\MainBundle\Controller\Frontend'
                to_controller_path: 'Acme\MainBundle\Controller\TabletFrontend'
                routes:
                    - 'acme_frontend_homepage'
                    - 'acme_frontend_news'
                    - 'acme_frontend_about_us'
    mobile:
        enabled: true
        controllers:
            -
                from_controller_path: 'Acme\MainBundle\Controller\Frontend'
                to_controller_path: 'Acme\MainBundle\Controller\MobileFrontend'
                routes:
                    - 'acme_frontend_homepage'
                    - 'acme_frontend_news'
                    - 'acme_frontend_about_us'
```

__4. Setting optional mobile view.__ 

An option is provided for optional rendering of mobile pages via setting of a cookie. If this cookie is set, this will override the redirection and render the desktop version until cookie expires.

```
device_detector:
    override_cookie: 'DEVICE_DETECTOR_OVERRIDE'
    tablet:
        enabled: true
        treat_as_mobile: false
        controllers:
            -
                from_controller_path: 'Acme\MainBundle\Controller\Frontend'
                to_controller_path: 'Acme\MainBundle\Controller\TabletFrontend'
                routes:
                    - 'acme_frontend_homepage'
                    - 'acme_frontend_news'
                    - 'acme_frontend_about_us'
    mobile:
        enabled: true
        controllers:
            -
                from_controller_path: 'Acme\MainBundle\Controller\Frontend'
                to_controller_path: 'Acme\MainBundle\Controller\MobileFrontend'
                routes:
                    - 'acme_frontend_homepage'
                    - 'acme_frontend_news'
                    - 'acme_frontend_about_us'
```
