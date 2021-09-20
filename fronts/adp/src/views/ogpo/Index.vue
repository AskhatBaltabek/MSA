<template>
  <div>
    <router-link to="/ogpo/create">
      <a-button type="primary" icon="plus-circle">Создать полис</a-button>
    </router-link>
    <a-divider />
    <a-table
        :columns="columns"
        :data-source="policies"
        row-key="id"
    >
      <a :href="`/ogpo/${id}`" slot="id" slot-scope="id">{{ id }}</a>
      <span slot="holder" slot-scope="record">{{ record.holder.full_name }}</span>
      <span slot="status" slot-scope="status">{{ statuses[status] }}</span>
    </a-table>
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  data() {
    return {
      columns: [
        { title: 'ID', dataIndex: 'id', scopedSlots: { customRender: 'id' }},
        { title: 'Номер полиса', dataIndex: 'policy_number', key: 'policy_number' },
        { title: 'Страхователь', key: 'holder', scopedSlots: { customRender: 'holder' } },
        { title: 'Дата начала', dataIndex: 'started_at', key: 'started_at' },
        { title: 'Дата окончания', dataIndex: 'ended_at', key: 'ended_at' },
        { title: 'Страховая премия', dataIndex: 'insurance_premium', key: 'insurance_premium' },
        { title: 'Статус', dataIndex: 'status', key: 'status', scopedSlots: { customRender: 'status' } },
      ],
      policies: [],
      statuses: {
        0: 'Новый',
        8: 'Выписан'
      }
    };
  },

  methods: {
    ...mapActions('ogpo', [
      'getPolicies'
    ]),

    async getPoliciesFromDatabase() {
      let result = await this.getPolicies();

      if (result.success) {
        this.policies = result.data;
      } else {
        this.$message.warning(result.message);
      }
    }
  },

  created() {
    this.getPoliciesFromDatabase();
  }
};
</script>
