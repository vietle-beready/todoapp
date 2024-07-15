// webpack.config.js
const path = require('path');

module.exports = {
  entry: './web/js/main.js',
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'web/js'),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
        },
      },
    ],
  },
  resolve: {
    alias: {
      alpinejs: path.resolve(__dirname, 'node_modules/alpinejs'),
    },
  },
  mode: 'development',
};
