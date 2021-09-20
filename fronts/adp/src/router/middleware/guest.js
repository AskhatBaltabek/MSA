export default function guest ({ next, store }){
    if(store.getters.isAuthenticated){
        return next({
           name: 'Home'
        })
    }

    return next()
}