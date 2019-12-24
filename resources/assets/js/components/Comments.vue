
<template>
<div class="card my-4">
  <h5 class="card-header">Leave a Comment:</h5>
  <div class="card-body">
    <form>
      <div class="form-group">
        <textarea ref="body" class="form-control" rows="3"></textarea>
      </div>
      <button type="submit" @click.prevent="addComment" class="btn btn-primary">Submit</button>
    </form>
  </div>


<div class="border p-3" v-for="comment in comments">
  
   {{ comment.user.name }} : &nbsp;
   {{ comment.body }}
    
   <div class="pull-right" v-if="userRole === 'admin'">
      <button class="btn btn-warning" @click.prevent="showEdit(comment)">Edit</button> 
      <button class="btn btn-danger" @click.prevent="deleteComment(comment.id)">Delete</button>
   </div>

   <div class="pull-right" v-else>
      <button v-if="comment.user.id == UserId" class="btn btn-warning" @click.prevent="showEdit(comment)">Edit</button> 
      <button v-if="comment.user.id == UserId" class="btn btn-danger" @click.prevent="deleteComment(comment.id)">Delete</button>
   </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <textarea class="form-control" rows="3" v-model="editComment"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" @click.prevent="updateComment">Update</button>
      </div>
    </div>
  </div>
</div>

</div>
</template>


<script>
export default {
  props: {
    UserId: {
      type: Number,
      required: true
    },
    userName: {
      type: String,
      required: true
    },
    postId: {
      type: Number,
      required: true
    },
    userRole: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      comments: [],
      editComment : '',
      IdComment : '',
      singleComment : []

      };
  },
  created() {
    this.fetchComments();
    Echo.private("comment").listen("CommentSent", e => {
        this.comments.push({
          user: {
            name: e.user.name
          },
          body: e.comment.body
        });
    });
  },
  methods: {
    fetchComments() {
      axios.get("/" + this.postId + "/comments").then(response => {
        this.comments = response.data;
      });
    },
    showEdit(comment){
        $('#exampleModal').modal('toggle');

        this.editComment = comment.body;
        this.IdComment = comment.id;
    },
    updateComment(comment){
      let body = this.editComment;
      axios
        .put('/api/comments/' + this.IdComment, { body })
        .then(response => {
          this.fetchComments()
          $('#exampleModal').modal('hide');
        })
        .catch(error => {
          if (!_.isEmpty(error.response)) {
            if ((error.response.status = 422)) {
              this.errors = error.response.data.errors;
              this.successful = false;
              this.error = true;
            }
          }
        });
    },
    deleteComment(id){
      axios.delete("/api/comments/" + id).then(response => this.fetchComments())
    },
    addComment() {
      let body = this.$refs.body.value;
      axios.post("/" + this.postId + "/comments", { body }).then((response) => {
        this.comments.push({
          user: {
            name: this.userName,
            id: this.UserId,
            },
          body: this.$refs.body.value,
          id: response.data.comment.id,

          });
        this.$refs.body.value = "";
      });
    }
  }
};
</script>
