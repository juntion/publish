const path = require('path');
module.exports = {
    entry: {
       index:[
           'babel-polyfill',
           './includes/templates/fiberstore/jscript/checkout/checkout_dev.js'
       ]
    },
    output: {
        filename: 'checkout_product.js',
        path: path.resolve(__dirname, 'includes/templates/fiberstore/jscript/checkout')
    },
    mode: 'production',
    devtool: "source-map" //
};
