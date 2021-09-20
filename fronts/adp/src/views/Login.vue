<template>
  <div class="">
    <a-row class="login-form-wrapper" type="flex" justify="center" align="middle">
      <a-col :span="5">
        <a-card hoverable style="width: 500px">
        <h1 align="center">Amanat Digital Platform</h1>
        <a-form
            id="components-form-demo-normal-login"
            :form="form"
            class="login-form height-50"
            @submit="handleSubmit"
        >
          <a-form-item>
            <a-input
                v-decorator="[
                  'login',
                  { rules: [{ required: true, message: 'Please input your username!' }] },
                ]"
                size="large"
                placeholder="Login"
            >
              <a-icon slot="prefix" type="user" style="color: rgba(0,0,0,.25)" />
            </a-input>
          </a-form-item>
          <a-form-item>
            <a-input
                v-decorator="[
                  'password',
                  { rules: [{ required: true, message: 'Please input your Password!' }] },
                ]"
                size="large"
                type="password"
                placeholder="Password"
            >
              <a-icon slot="prefix" type="lock" style="color: rgba(0,0,0,.25)" />
            </a-input>
          </a-form-item>
          <a-form-item>
            <a-button :loading="spinning" size="large" type="primary" html-type="submit" class="login-form-button">
              Войти
            </a-button>
          </a-form-item>
        </a-form>
        </a-card>
      </a-col>
    </a-row>
  </div>
</template>

<script>
import {mapState} from "vuex";

export default {
  beforeCreate() {
    this.form = this.$form.createForm(this, { name: 'normal_login' });
  },
  computed: {
    ...mapState({
      spinning: state => state.spinning
    })
  },
  mounted() {

  },
  methods: {
    handleSubmit(e) {
      e.preventDefault();
      this.form.validateFields((err, values) => {
        if (!err) {
          this.$store.dispatch('LOGIN', values)
            .then(() => {
              this.$router.go('/')
            })
            .catch(e => {
              this.$message.error(e.response.data.data.error)
            })
        }
      });
    },
  },
};
</script>
<style>
.login-form-wrapper {
  min-height: 600px;
}

#components-form-demo-normal-login .login-form {
  max-width: 300px;
}
#components-form-demo-normal-login .login-form-forgot {
  float: right;
}
#components-form-demo-normal-login .login-form-button {
  width: 100%;
}
</style>