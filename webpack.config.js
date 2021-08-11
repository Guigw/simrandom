const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = (env) => {
    return {
        entry: './assets/index.ts',
        devtool: (env.production) ? false : "eval",
        mode: (env.production) ? "production" : "development",
        watch: (!env.production),
        plugins: [
            new HtmlWebpackPlugin({
                title: "Caching",
                inject: true,
                template: "./assets/templates/index.html"
            })
        ],
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
                    options: {presets: ["@babel/env"]}
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
            filename: '[name].[contenthash].js',
            path: path.resolve(__dirname, 'htdocs/dist'),
            publicPath: "/simrandom/htdocs/dist/",
            clean: true
        },
        optimization: {
            splitChunks: {
                chunks: "all",
            }
        }
    }

};