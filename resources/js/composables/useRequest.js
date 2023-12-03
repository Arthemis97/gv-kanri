import useAuthStore from "../stores/auth";
const apiurl = import.meta.env.VITE_API_URL;
const BASE_API_URL = `${apiurl}/api`;

const useRequest = {
    async get(url) {
        const authStore = useAuthStore();
        const headers = {
            Accept: "application/json",
        };
        if (authStore.token) {
            headers.Authorization = `Bearer ${authStore.token}`;
        }
        const resp = await fetch(`${BASE_API_URL}${url}`, {
            method: "GET",
            headers: headers,
        });
        try {
            const respdata = await resp.json();
            return {data: respdata};
        } catch (error) {
            try {
                const responseBody = await resp.text();
                if (error instanceof Response && error.status == 401) {
                    useEvent.emit("logout");
                }
                return responseBody;
            } catch (e) {
                console.error('Failed to get response body:', e);
            }
        }
    },
    async post(url, data, type = "application/json") {
        const authStore = useAuthStore();
        const headers = {
            Accept: "application/json",
        };
        let payload = JSON.stringify(data);
        if (authStore.token) {
            headers.Authorization = `Bearer ${authStore.token}`;
        }
        if (type) {
            headers["Content-Type"] = type;
        } else {
            payload = data;
        }
        const resp = await fetch(`${BASE_API_URL}${url}`, {
            method: "POST",
            headers: headers,
            body: payload,
        });


        try {
            const respdata = await resp.json();
            return {data: respdata};
        } catch (error) {
            try {
                const responseBody = await resp.text();
                if (error instanceof Response && error.status == 401) {
                    useEvent.emit("logout");
                }
                return responseBody;
            } catch (e) {
                console.error('Failed to get response body:', e);
            }
        }

    },
    async put(url, data, type = "application/json") {
        const authStore = useAuthStore();
        const headers = {
            Accept: "application/json",
        };
        let payload = JSON.stringify(data);
        if (authStore.token) {
            headers.Authorization = `Bearer ${authStore.token}`;
        }
        if (type) {
            headers["Content-Type"] = type;
        } else {
            payload = data;
        }
        const resp = await fetch(`${BASE_API_URL}${url}`, {
            method: "PUT",
            headers: headers,
            body: payload,
        });

        try {
            const respdata = await resp.json();
            return {data: respdata};
        } catch (error) {
            try {
                const responseBody = await resp.text();
                if (error instanceof Response && error.status == 401) {
                    useEvent.emit("logout");
                }
                return responseBody;
            } catch (e) {
                console.error('Failed to get response body:', e);
            }
        }
    },
    async del(url) {
        const authStore = useAuthStore();
        const headers = {
            Accept: "application/json",
        };
        if (authStore.token) {
            headers.Authorization = `Bearer ${authStore.token}`;
        }
        const resp = await fetch(`${BASE_API_URL}${url}`, {
            method: "DELETE",
            headers: headers,
        });


        try {
            const respdata = await resp.json();
            return {data: respdata};
        } catch (error) {
            try {
                const responseBody = await resp.text();
                if (error instanceof Response && error.status == 401) {
                    useEvent.emit("logout");
                }
                return responseBody;
            } catch (e) {
                console.error('Failed to get response body:', e);
            }
        }
    },
};

export default useRequest;
