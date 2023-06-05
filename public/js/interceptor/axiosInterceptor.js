axios.interceptors.request.use(function (config) {
    // Do something before sending the request
    Alpine.store('global').isLoading = true
    return config;
}, function (error) {
    // Do something with request error
    return Promise.reject(error);
});
axios.interceptors.response.use(function (response) {
    // Do something with response data
    Alpine.store('global').isLoading = false
    return response;
}, function (error) {
    Alpine.store('global').isLoading = false
    // Do something with response error
    return Promise.reject(error);
});