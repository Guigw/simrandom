const path = require('path');

module.exports = {
  entry: './assets/index.ts',
  output: {
      filename: 'main.js',
      path: path.resolve(__dirname, 'htdocs/dist')
  }
};