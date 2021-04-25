const requireRoutes = require.context('~/pages/', true, /routes\/.*index.js$/)

let routersNameArr = []
requireRoutes.keys().forEach(fileName => {

    let str = fileName.split('/')

    str = str[1]
        // if (fileName === `./${str}/router/index.js`) {
        // console.log('check' + fileName);
    const componentConfig = requireRoutes(fileName)
    if (componentConfig.default.length == 1) {
        routersNameArr.push(componentConfig.default[0])
    } else {
        for (let index = 0; index < componentConfig.default.length; index++) {
            routersNameArr.push(componentConfig.default[index])
        }
    }
    // }
})


export default routersNameArr