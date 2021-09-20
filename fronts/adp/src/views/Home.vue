<template>
  <div>
    <a-row :gutter="16">
      <a-col :span="14">
        <a-affix :offset-top="20">
          <a-row :gutter="[16,16]">
            <a-col :span="8" v-for="(module, index) in modules" :key="index">
              <card :item="module" />
            </a-col>
          </a-row>
        </a-affix>
      </a-col>
      <a-col :span="10" class="topics-area">
        <a-list v-if="news.length" item-layout="vertical" :data-source="news">
          <div slot="footer">
            <a-button type="primary">
              Все новости
            </a-button>
          </div>
          <template slot-scope="item" slot="renderItem">
            <news-item :item="item"/>
          </template>
        </a-list>
        <a-skeleton v-else active :paragraph="{rows:30}" />
      </a-col>
    </a-row>
  </div>
</template>

<script>
import {mapGetters, mapState} from "vuex";
import NewsItem from "@/components/home/NewsItem";
import Card from "@/components/global/Card";

export default {
  components: {Card, NewsItem},
  data() {
    return {
      modules: [
        {
          title: 'Полисы',
          description: 'The ship is more sensor now than particle. bare and surprisingly human.',
          icon: 'snippets',
          url: '/policies'
        },
        {
          title: 'Hydras',
          description: 'Fortis, dexter amors foris examinare de barbatus, castus hilotae.',
          icon: 'form'
        },
        {
          title: 'Garlic',
          description: 'Ice shredded chicken in a bowl with plain vinegar for about an hour to cut their sweetness.',
          icon: 'highlight'
        },
        {
          title: 'Wet malarias',
          description: 'Stutter loudly like an old seashell.',
          icon: 'scissor'
        },
        {
          title: 'Malfunction',
          description: 'The ship is more sensor now than particle. bare and surprisingly human.',
          icon: 'diff'
        },
        {
          title: 'Studere',
          description: 'Cum historia peregrinationes, omnes hippotoxotaes manifestum placidus, teres advenaes.',
          icon: 'sliders'
        },
      ]
    }
  },
  mounted() {
    this.$store.dispatch('LOAD_NEWS');
  },
  computed: {
    ...mapGetters(['hasRoles', 'hasRole']),
    ...mapState({
      news: state => state.news.data,
      newsLoading: state => state.news.loading,
    })
  }
}
</script>

<style lang="scss">
.topics-area {
  border-left: 1px solid #e3e3e3;
  border-right: 1px solid #e3e3e3;
}
</style>