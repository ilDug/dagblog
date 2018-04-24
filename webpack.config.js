const path = require('path');
var webpack = require('webpack');

module.exports = {
    entry: './src/scripts/index.ts',
    output: {
        filename:'boundle.js',
        path: path.resolve(__dirname, 'src')
    },
    module: {
       rules: [
         { test: /\.tsx?$/, use: 'ts-loader', exclude: /node_modules/ }
       ]
    },
    resolve: {
       extensions: [".tsx", ".ts", ".js"]
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            Popper: ['popper.js', 'default']
        })
    ],
    watch:false
};
