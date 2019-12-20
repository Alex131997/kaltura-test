import Vuex from 'vuex';
import Vue from 'vue';
import MediaList from "./components/Media/MediaList";

Vue.use(Vuex);

const store = new Vuex.Store({
  namespaced: true,
  modules: {
    media: MediaList,
  }
});

export default store;
