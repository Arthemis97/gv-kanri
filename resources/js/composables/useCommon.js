import { storeToRefs } from "pinia";
import useAuthStore from "../stores/auth"

export const objectToQueryString = (obj) => {
    const parts = [];
    for (const key in obj) {
        if (obj.hasOwnProperty(key)) {
            const value = encodeURIComponent(obj[key]);
            if (obj[key] && obj[key].length > 0) {
                parts.push(`${encodeURIComponent(key)}=${value}`);
            }
        }
    }
    return parts.join("&");
};
