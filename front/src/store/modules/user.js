import firebase from 'firebase/app'
import 'firebase/auth'
import { currentUser } from '../../constants/config'
import webServices from '../../webServices'

export default {
  state: {
    currentUser: localStorage.getItem('user') != null ? JSON.parse(localStorage.getItem('user')) : null,
    loginError: null,
    processing: false,
    forgotMailSuccess:null,
    resetPasswordSuccess:null
  },
  getters: {
    currentUser: state => state.currentUser,
    processing: state => state.processing,
    loginError: state => state.loginError,
    forgotMailSuccess: state => state.forgotMailSuccess,
    resetPasswordSuccess:state => state.resetPasswordSuccess,
  },
  mutations: {
    setUser(state, payload) {
      state.currentUser = payload
      state.processing = false
      state.loginError = null
    },
    setLogout(state) {
      state.currentUser = null
      state.processing = false
      state.loginError = null
    },
    setProcessing(state, payload) {
      state.processing = payload
      state.loginError = null
    },
    setError(state, payload) {
      state.loginError = payload
      state.currentUser = null
      state.processing = false
    },
    setForgotMailSuccess(state) {
      state.loginError = null
      state.currentUser = null
      state.processing = false
      state.forgotMailSuccess=true
    },
    setResetPasswordSuccess(state) {
      state.loginError = null
      state.currentUser = null
      state.processing = false
      state.resetPasswordSuccess=true
    },
    clearError(state) {
      state.loginError = null
    }
  },
  actions: {
    login({ commit }, payload) {
      commit('clearError')
      commit('setProcessing', true)
      webServices.post('admin/login', JSON.stringify(payload), { headers: { 'Content-Type': 'application/json' } })
      .then(response => {
        if (response.data.success) {
          const item = {
            name: response.data.data.user.name,
            email: response.data.data.user.email,
            role: response.data.data.user.role,
            token:response.data.data.token,
            ...currentUser }
          localStorage.setItem('user', JSON.stringify(item))
          commit('setUser', {
            name: item.name,
            email: item.email,
            role:item.role,
            token:item.token,
            ...currentUser })
        } else {
          localStorage.removeItem('user')
          commit('setError', "Your email or password incorrect.")
          setTimeout(() => {
            commit('clearError')
          }, 3000)
        }
      })
      .catch(error => {
        localStorage.removeItem('user')
        commit('setError', error.data)
        setTimeout(() => {
          commit('clearError')
        }, 3000)
      })
    },
    forgotPassword({ commit }, payload) {
      commit('clearError')
      commit('setProcessing', true)
      firebase
        .auth()
        .sendPasswordResetEmail(payload.email)
        .then(
          user => {
            commit('clearError')
            commit('setForgotMailSuccess')
          },
          err => {
            commit('setError', err.message)
            setTimeout(() => {
              commit('clearError')
            }, 3000)
          }
        )
    },
    resetPassword({ commit }, payload) {
      commit('clearError')
      commit('setProcessing', true)
      firebase
        .auth()
        .confirmPasswordReset(payload.resetPasswordCode,payload.newPassword)
        .then(
          user => {
            commit('clearError')
            commit('setResetPasswordSuccess')
          },
          err => {
            commit('setError', err.message)
            setTimeout(() => {
              commit('clearError')
            }, 3000)
          }
        )
    },
    signOut({ commit }) {
      localStorage.removeItem('user')
    }
  }
}
