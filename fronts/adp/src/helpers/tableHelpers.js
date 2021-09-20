import {isEmptyObject} from "ant-design-vue/lib/vc-form/src/utils";

function setFilters(params) {
    let filters = ''
    let orders = ''
    let pagination = ''

    if(params) {
        if(params.filters && !isEmptyObject(params.filters)) {
            filters = '?'
            for(let prop in params.filters)
                filters += `&where[${prop}][operator]=LIKE&where[${prop}][value]=\\%\\${params.filters[prop]}\\%\\`
        }

        if (params.sorter && !isEmptyObject(params.sorter)) {
            if (params.sorter.order) {
                if(!filters) orders = '?'
                orders += `&order[${params.sorter.field}]=${params.sorter.order}`
            }
        } else {
            if(!filters) orders = '?'
            orders += `&order[id]=desc`
        }

        if(params.pagination && !isEmptyObject(params.pagination)) {
            if(!orders && !filters) pagination = '?'
            pagination += `&pagination[pageSize]=${params.pagination.pageSize}&page=${params.pagination.current}`
        }
    }

    return filters + orders + pagination + '&with[]=client&with[]=car&with[]=status';
}

export { setFilters }