const path = require('path');
const webpack = require('webpack');

module.exports = {
    entry: './assets/index.ts',
    devtool: "inline-source-map",
    mode: "development",
    module: {
        rules: [
            {
                test: /\.(ts|tsx)$/,
                use: "ts-loader",
                exclude: /nodes_modules/
            },
            {
                test: /\.(js|jsx)$/,
                exclude: /(node_modules|bower_components)/,
                loader: "babel-loader",
                options: { presets: ["@babel/env"] }
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"]
            },
            {
                test: /\.less$/i,
                use: [
                    // compiles Less to CSS
                    "style-loader",
                    "css-loader",
                    "less-loader",
                ],
            }
        ]
    },
    resolve: {
        extensions: ["*", ".js", ".jsx", ".ts", ".tsx"]
    },
    output: {
        filename: 'main.js',
        path: path.resolve(__dirname, 'htdocs/dist'),
        publicPath: "/htdocs/"
    }
};