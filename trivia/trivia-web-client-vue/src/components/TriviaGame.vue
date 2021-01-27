
<template>
    <div>
        <div v-if="isLoading">Loading players...</div>
        <div v-else>
            <table className="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Answers</th>
                    <th>Points</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <template v-for="player in players">
                    <tr v-bind:key="player.id">
                        <td>{{player.id}}</td>
                        <td>{{player.name}}</td>
                        <td>{{player.answers}}</td>
                        <td>{{player.points}}</td>
                        <td>
                            <button class="button is-primary" v-bind:class="{ 'is-loading' : isDeleting(player.id) }" @click="deletePlayer(player.id)">Delete Player</button>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
            <player-form @completed="addPlayer"></player-form>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { API_BASE_URL } from '../config'
import PlayerForm from './PlayerForm'
import Vue from 'vue'


export default{
    components:{
        PlayerForm
    },
    data(){
        return{
            isLoading:true,
            players:{}
        }
    },
    methods:{
        addPlayer(player){
            this.players.push(player)
        },
        isDeleting(id){
            let index = this.players.findIndex(player => player.id === id)
            console.log(index)

            return console.log(this.players[index].isDeleting)
        },
        async deletePlayer(id){
            let index = this.players.findIndex(player => player.id === id)
            Vue.set(this.players[index], 'isDeleting', true)
            await axios.delete(API_BASE_URL + '/players/' + id)
            this.players.splice(index, 1)
        }
    },
    async created(){
        try{
            const response = await axios.get(API_BASE_URL + '/players')
            this.players = response.data.data
            this.isLoading = false
            console.log('fetched data')
        }
        catch(e){
            console.log('error fetching data')
        }
    }
}
</script>
