module.exports = {
    configureWebpack:{
        performance: {
        },
        optimization: {
            splitChunks: {
                minSize: 512000,
                maxSize: 512000,
            }
        }
    }
}