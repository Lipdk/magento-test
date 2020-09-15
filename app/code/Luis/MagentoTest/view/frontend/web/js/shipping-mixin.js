define(function () {
  'use strict';

  var mixin = {

    /**
     *
     * @param {Column} elem
     */
    setShippingInformation: function () {
      window.location.href = '/checkout';
    }
  };

  return function (target) {
    return target.extend(mixin);
  };
});