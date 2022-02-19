const webpack = require('webpack');
const path = require('path');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const TerserJSPlugin = require('terser-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const WebpackCleanPlugin = require('webpack-clean-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const isRelease = (process.env.NODE_ENV === 'release');
const Notification = require('./plugins/notification');
const Manifest = require('./plugins/manifest');

const config = {
    mode: !isRelease ? 'development' : 'production',
    entry: {
        main: [
            './src/js/main.js',
            './src/sass/main.scss'
        ]
    },
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: `[name].js${isRelease ? '?[chunkhash]' : ''}`,
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [MiniCssExtractPlugin.loader, 'css-loader'],
            },
            {
                test: /\.less$/,
                use: [MiniCssExtractPlugin.loader, 'css-loader', 'less-loader'],
            },
            {
                test: /\.(sass|scss)$/,
                use: [
                    {
                        loader: 'style-loader'
                    },
                    {
                        // translates CSS into CommonJS modules
                        loader: 'css-loader'
                    },
                    {
                        // Run postcss actions
                        loader: 'postcss-loader',
                        options: {
                            // `postcssOptions` is needed for postcss 8.x;
                            // if you use postcss 7.x skip the key
                            postcssOptions: {
                                // postcss plugins, can be exported to postcss.config.js
                                plugins: function () {
                                    return [
                                        require('autoprefixer')
                                    ];
                                }
                            }
                        }
                    },
                    {
                        // compiles Sass to CSS
                        loader: 'sass-loader',
                    }
                ]
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader",
                    options: {
                        plugins: ['syntax-dynamic-import'],
                        presets: [
                            [
                                '@babel/preset-env',
                                {
                                    modules: false
                                }
                            ]
                        ]
                    }
                }
            },
            {
                test: /\.(JPG|gif|svg|gif|png)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                include: /images/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: 'images/[name].[hash].[ext]',
                        }
                    },
                    {
                        loader: 'image-webpack-loader',
                        options: {
                            webp: {
                                quality: 75,
                            }
                        }
                    }
                ]
            },
            {
                test: /\.(eot|ttf|woff|woff2|svg)$/,
                exclude: /images/,
                loader: 'file-loader',
                options: {
                    name: 'fonts/[name].[ext]',
                },
            },
        ]
    },
    plugins: [
        new webpack.ProgressPlugin(),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            Popper: ['popper.js', 'default'],
        }),
        new CopyPlugin([

            {
                from: './src/js/pinoox.js',
                flatten: true,
            },
        ]),
        new MiniCssExtractPlugin({
            filename: `[name].css${isRelease ? '?[chunkhash]' : ''}`,
        }),
        new VueLoaderPlugin(),
        new Notification(),
    ],
    optimization: {
        minimize: isRelease,
        minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
        splitChunks: {
            cacheGroups: {
                default: false,
                vendors: false,
                vendor: {
                    name: 'vendor',
                    chunks: 'all',
                    test: /[\\/](node_modules|libs)[\\/]/
                }
            }
        }
    },
    resolve: {
        alias: {
            '@img': path.resolve(__dirname, 'src/images'),
            '@': path.resolve(__dirname, 'src')
        },
    },
};

module.exports = config;


if (isRelease) {
    module.exports.plugins.push(new Manifest('manifest.json'));

    module.exports.plugins.push(
        new WebpackCleanPlugin({
            on: "emit",
            path: ['./dist']
        }));
}

