const path = require('path');
const CopyPlugin = require("copy-webpack-plugin");

const rootDir = path.resolve(__dirname, './..');
const publicDir = rootDir.concat('/public');
const publicAssetsDir = publicDir.concat('/assets');
// module.exports = {
//     // plugins: [
//     //     new CopyPlugin({
//     //         patterns: [
//     //             { from: "source", to: "dest" },
//     //             { from: "other", to: "public" },
//     //         ],
//     //     }),
//     // ],
// };
module.exports = {
    mode: 'development',
    context: path.resolve(__dirname, 'src'),
    entry: [
        './js/index.js',
        './sass/main.scss',
    ],
    output: {
        filename: 'js/main.js',
        path: path.resolve(__dirname, publicAssetsDir),
        clean: true
    },
    devtool: 'inline-source-map',
    devServer: {
        contentBase: publicDir,
    },
    watchOptions: {
        ignored: '**/node_modules'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: 'babel-loader',
            },
            {
                test: /\.s[ac]ss$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: "file-loader",
                        options: {
                            outputPath: 'css/',
                            name: '[name].css',
                        },
                    },
                    {
                        loader: "sass-loader",
                    }
                ],
            },
        ],
    },
    plugins: [
        new CopyPlugin([
            {from: "./images", to: publicAssetsDir.concat("/images")},
        ]),
    ],
};