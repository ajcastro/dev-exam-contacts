<template>
  <div class="q-pa-md">
    <q-table
      title="Treats"
      :data="data"
      :columns="columns"
      row-key="id"
      :pagination.sync="pagination"
      :loading="loading"
      :filter="filter"
      @request="onRequest"
      binary-state-sort
    >
    </q-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      filter: '',
      loading: false,
      pagination: {
        sortBy: 'desc',
        descending: false,
        page: 1,
        rowsPerPage: 3,
        rowsNumber: 10,
      },
      columns: [
        {
          name: 'name', label: 'Name', field: 'name', sortable: false,
        },
        {
          name: 'email', label: 'Email', field: 'email', sortable: false,
        },
        {
          name: 'phone', label: 'Phone', field: 'phone', sortable: false,
        },
        {
          name: 'address', label: 'Address', field: 'address', sortable: false,
        },
      ],
      data: [],
    };
  },
  mounted() {
    // get initial data from server (1st page)
    this.onRequest({
      pagination: this.pagination,
      filter: undefined,
    });
  },
  methods: {
    async onRequest(/* props */) {
      const res = await this.$axios.get('http://dev-contacts.test/api/contact');

      const { meta } = res.data.data;

      this.data = res.data.data;
      this.pagination = {
        sortBy: null,
        descending: false,
        page: meta.current_page,
        rowsPerPage: meta.per_page,
        rowsNumber: meta.total,
      };
    },
  },
};
</script>
