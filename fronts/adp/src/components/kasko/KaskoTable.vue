<template>
  <a-table
    :loading="loading"
    :rowKey="(r,i)=>i"
    :columns="columns"
    :pagination="pagination"
    :data-source="data"
    @change="handleTableChange"
  >
    <template slot="status" slot-scope="status">
      {{ status.title }}
    </template>
    <div slot="expandedRowRender" slot-scope="record" style="margin: 0">
      <a-row :gutter="16">
        <a-col :span="8">
          <a-card size="small" title="Страхователь" >
            <p>ФИО: <b>{{ record.client.fio }}</b></p>
            <p>ИИН: <b>{{ record.client.iin }}</b></p>
          </a-card>
        </a-col>
        <a-col :span="8">
          <a-card size="small" title="Автомобиль">
            <p>Марка: <b>{{ record.car.mark }}</b></p>
            <p>Модель: <b>{{ record.car.model }}</b></p>
            <p>Год: <b>{{ record.car.born }}</b></p>
          </a-card>
        </a-col>
        <a-col :span="8">
          <a-card size="small" title="Выгодоприобретатель">
            <template v-if="record.beneficiary.natural_person_bool">
              <p>ФИО: <b>{{ record.beneficiary.name }}</b></p>
              <p>ИИН: <b>{{ record.beneficiary.iin }}</b></p>
            </template>
            <template v-else>
              <p>Название: <b>{{ record.beneficiary.name }}</b></p>
              <p>БИН: <b>{{ record.beneficiary.iin }}</b></p>
            </template>
          </a-card>
        </a-col>
      </a-row>
    </div>
    <div
      slot="filterDropdown"
      slot-scope="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }"
      style="padding: 8px"
    >
      <a-input
        v-ant-ref="c => (searchInput = c)"
        :placeholder="`Search ${column.dataIndex}`"
        :value="selectedKeys[0]"
        style="width: 188px; margin-bottom: 8px; display: block;"
        @change="e => setSelectedKeys(e.target.value ? [e.target.value] : [])"
        @pressEnter="() => handleSearch(selectedKeys, confirm, column.dataIndex)"
      />
      <a-button
        type="primary"
        icon="search"
        size="small"
        style="width: 90px; margin-right: 8px"
        @click="() => handleSearch(selectedKeys, confirm, column.dataIndex)"
      >
        Поиск
      </a-button>
      <a-button size="small" style="width: 90px" @click="() => handleReset(clearFilters, column.dataIndex)">
        Reset
      </a-button>
    </div>
  </a-table>
</template>
<script>
import {mapGetters, mapState} from "vuex";

export default {
  data() {
    return {
      columns: [
        {
          title: 'ID',
          dataIndex: 'id',
          sorter: true,
          sortDirections: ['asc', 'desc'],
          customRender: (v) => {
            let link = `/kasko/${v}`
            return <router-link to={link}>{v}</router-link>;
          }
        },
        {
          title: 'Номер полиса',
          dataIndex: 'policy_number',
          type: 'text',
          scopedSlots: {
            filterDropdown: 'filterDropdown',
            filterIcon: 'filterIcon',
            customRender: 'customRender',
          },
        },
        {
          title: 'Продукт',
          dataIndex: 'product_code',
          type: 'text',
          scopedSlots: {
            filterDropdown: 'filterDropdown',
            filterIcon: 'filterIcon',
            customRender: 'customRender',
          },
        },
        {
          title: 'Страхователь',
          dataIndex: 'client.fio',
          type: 'text',
          scopedSlots: {
            filterDropdown: 'filterDropdown',
            filterIcon: 'filterIcon',
            customRender: 'customRender',
          },
        },
        {
          title: 'Дата начала',
          dataIndex: 'start_date',
          type: 'text',
          scopedSlots: {
            filterDropdown: 'filterDropdown',
            filterIcon: 'filterIcon',
            customRender: 'customRender',
          },
        },
        {
          title: 'Дата окончания',
          dataIndex: 'end_date',
          type: 'text',
          scopedSlots: {
            filterDropdown: 'filterDropdown',
            filterIcon: 'filterIcon',
            customRender: 'customRender',
          },
        },
        {
          title: 'Статус',
          dataIndex: 'status',
          key: 'operation',
          fixed: 'right',
          scopedSlots: { customRender: 'status' },
        }
      ],
      params: {
        filters: {},
        sorter: {},
        pagination: {
          pageSize: 15,
          total: 1519,
          current: 1
        }
      },
    };
  },
  methods: {
    handleSearch(selectedKeys, confirm, dataIndex) {
      if(!selectedKeys[0]) return;
      this.params.filters[dataIndex] = selectedKeys[0];
      confirm()
    },
    handleReset(clearFilters, dataIndex) {
      delete this.params.filters[dataIndex];
      clearFilters()
    },
    handleTableChange(pagination, filters, sorter) {
      this.params.sorter = sorter
      this.params.pagination = pagination
      this.loadData()
    },
    loadData() {
      this.$store.dispatch('LOAD_KASKO_POLICIES', this.params)
    },
  },
  computed: {
    ...mapState({
      data: state => state.kasko.data,
      loading: state => state.kasko.loading,
      pagination: state => state.kasko.pagination
    }),
    ...mapGetters(['filteredData'])
  },
  mounted() {
    this.loadData()
  },
};
</script>