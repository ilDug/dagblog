const path = require('path');
var webpack = require('webpack');

module.exports = {
    entry:{
        index: './src/scripts/index.ts',
        vendors: './src/scripts/vendors.ts'
    },
    output: {
        filename:'bundle.[name].js',
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
// module.exports = {
//     entry: './src/scripts/index.ts',
//     output: {
//         filename:'bundle.js',
//         path: path.resolve(__dirname, 'src')
//     },
//     module: {
//        rules: [
//          { test: /\.tsx?$/, use: 'ts-loader', exclude: /node_modules/ }
//        ]
//     },
//     resolve: {
//        extensions: [".tsx", ".ts", ".js"]
//     },
//     plugins: [
//         new webpack.ProvidePlugin({
//             $: 'jquery',
//             jQuery: 'jquery',
//             'window.jQuery': 'jquery',
//             Popper: ['popper.js', 'default']
//         })
//     ],
//     watch:false
// };
