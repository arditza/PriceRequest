# Azra_PriceRequest

> The scope of this module is to hide final price from product page and display a price quote form to enable customers to request a custom price from store managers.


## Features

* Through a confguration store managers can easily enable/disable this feature
* Shows price request form on product detail page instead of product final price
* Customer data are submited via ajax for better UX
* Price quotes are stored in database and displayed on admin panel in a dedicated section. CRUD operations are supported.


## Install

```
composer require azra/module-price-request
bin/magento module:enable Azra_PriceRequest
```

---

## Configuration

Configuration path **Stores -> Configuration -> Azra Configurations -> General Configurations**

| Option | Description |
| --- | --- |
|Module Enable | Allows admins to select whether to enable the price request feature |


### Todo/Issues
    1. 

### Supported 
Magento CE 2.3.x
