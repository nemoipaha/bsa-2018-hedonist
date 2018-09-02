export default {
    getFilteredByName: state => (userLists, name) => {
        let filtered = {};
        Object.keys(userLists).forEach( (key) => {
            let userList = userLists[key];
            if(userList.name
                .toLowerCase()
                .indexOf(
                    name.toLowerCase()
                ) > -1)
                filtered[userList.id] = userList;
        });
        return filtered;
    },

    getById: state => id => {
        return state.userLists.byId[id];
    },

    getUniqueCities: (state, getters) => userList => {
        let cities = {};
        userList.places
            .map(id => state.places.byId[id].city)
            .forEach((id) => {
                cities[id] = state.cities.byId[id];
            });
        return cities;
    },

    getFilteredByCity: (state, getters) => (userLists, cityId) => {
        let filtered = {};
        Object.keys(userLists).forEach( (key) => {
            let userList = userLists[key];
            let cities = Object.keys(
                getters.getUniqueCities(userList)
            ).filter(
                id => parseInt(id) === cityId
            );
            if(cities.length > 0) filtered[userList.id] = userList;
        });
        return filtered;
    },

    getPlaceById: (state, getters) => (id) => {
        return state.places.byId[id];
    },

    getPhotosByIds: (state, getters) => (ids) => {
        return ids.map((id) => state.photos.byId[id]);
    },

    getPlacesByIds: (state, getters) => (ids) => {
        return ids.map((id) => {
            const place = getters.getPlaceById(id);
            return {
                ...place,
                photos: getters.getPhotosByIds(place.photos),
                city: state.cities.byId[place.city],
                category: state.categories.byId[place.category]
            };
        });
    },

    getUserLists: (state) => _.map(state.userLists.allIds, (id) => state.userLists.byId[id])
};
