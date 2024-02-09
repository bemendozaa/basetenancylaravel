import { defineStore } from 'pinia'


export const useMainStore = defineStore('main', {
	state: () => ({
		isTenant: null,
	}),
	actions: {
		setMainConfig(payload) 
		{
			if (payload.isTenant != undefined) this.isTenant = payload.isTenant
		},
	},
});
