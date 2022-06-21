const fetchApi = async (body, method = false) => {
    const SERVER_URL = './api/index.php';
    const METHOD = 'POST'
    const PARAMETERS = {
        apiUrl: SERVER_URL,
        rest: {
            body: body,
            method: method || METHOD,
        },
    };
    try {
        const response = await fetch(PARAMETERS.apiUrl, PARAMETERS.rest);
        if (response.ok) {
            return await response.text();
        }
        return false;
    } catch(error) {
        return false;
    }
};

export { fetchApi };
