<template>
    <div id="posts">

        <div>
            <button 
                v-if="next" 
                type="button" 
                @click="navigate(next)" 
                class="m-3 btn btn-primary"
            >
              Next
            </button>
            <button 
                v-if="prev" 
                type="button" 
                @click="navigate(prev)" 
                class="m-3 btn btn-primary"
            >
              Previous
            </button>
        </div>
    </div>
</template>

<script>
export default {
  mounted() {
    this.getPosts();
  },
  props: {
    userId: {
        type: Number,
        required: true
    }
    },
  data() {
    return {
      posts: {},
      next: null,
      prev: null,
    };
  },
  methods: {
    getPosts(address) {
      axios.get(address ? address : "/api/posts").then(response => {
        this.posts = response.data.data;
        this.prev = response.data.links.prev;
        this.next = response.data.links.next;
      });
    },
    deletePost(id) {
      axios.delete("/api/posts/" + id).then(response => this.getPosts())
    },
    navigate(address) {
      this.getPosts(address)
    }
  }
};
</script>