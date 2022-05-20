import axios from 'axios'
import router from '../router'
import { createStore } from 'vuex'

const store = createStore({
	state: {
		authenticated: false,
		user: {}
	},

	getters: {
		authenticated(state){
			return state.authenticated
		},
		
		user(state){
			return state.user
		}
	},

	mutations:{
		GET_USER (state) {
			const user = localStorage.getItem('user')
			const token = localStorage.getItem('token')
			
			state.user = JSON.parse(user) || {}
			state.authenticated = token ? true : false
		},

		SET_AUTHENTICATED (state, value) {
			localStorage.setItem("token", value)

			state.authenticated = value !== null
		},

		SET_USER (state, value) {
			localStorage.setItem("user", JSON.stringify(value))
			state.user = value
		},

		LOGOUT (state) {
			state.user = {}
			state.authenticated = false
		}
	},

	actions: {
		init({ commit }) {
			commit('GET_USER')
		},

		login({ commit }, credentials) {
			return axios.post('/api/login', credentials).then(({ data })=>{
				commit('SET_USER', data.user)
				commit('SET_AUTHENTICATED', data.access_token)

				router.push({ name:'Products.List' })
			}).catch(({response:{ data }})=>{
				commit('SET_USER', {})
				commit('SET_AUTHENTICATED', null)
			})
		},

		register({ commit }, data) {
			return axios.post('/api/register', data).then(({ data })=>{
				console.log(data)
				commit('SET_USER', data.user)
				commit('SET_AUTHENTICATED', data.access_token)

				// router.push({ name:'Products.List' })
			}).catch(({response:{ data }})=>{
				commit('LOGOUT')
			})
		},

		logout({ commit }) {
			return axios.post('/api/logout').then(({ data })=>{
				commit('LOGOUT')

				localStorage.clear()
				router.push({ name:'Login' })
			})
		}
	}
})


export default store