<template>
    <div>
        <v-alert v-if="stolIzbrisan" type="success">
            Stol uspješno izbrisan!
        </v-alert>
        <div>
            <div class="card-body table-responsive p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Naziv</th>
                            <th>Broj gostiju</th>
                            <th>Status</th>
                            <th>Uredi/Briši</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="stol in stolovi" :key="stol.id">
                            <td>{{ stol.naziv }}</td>
                            <td>{{ stol.broj_gostiju }}</td>
                            <td>{{ stol.status }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#stolModal"
                                    @click="dohvatiStol(stol)"
                                >
                                    Uredi
                                </button>
                                <button
                                    @click="izbrisiStol(stol.id)"
                                    class="btn btn-sm btn-danger"
                                >
                                    <i class="fa fa-trash"></i> Izbriši
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <loading :loading="loading"></loading>
        <div
            class="modal fade"
            id="stolModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="stolModalLabel"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-lg"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stolModalLabel">Uredi</h5>
                        <button
                            type="button"
                            class="close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <v-form>
                            <v-text-field
                                label="Naziv"
                                v-model="form.naziv"
                            ></v-text-field>
                            <span class="text-danger" v-show="stolError.naziv"
                                >Unesite naziv!</span
                            >

                            <v-text-field
                                label="Broj gostiju"
                                v-model="form.broj_gostiju"
                            ></v-text-field>
                            <span
                                class="text-danger"
                                v-show="stolError.broj_gostiju"
                                >Unesite naziv!</span
                            >

                            <v-select
                                placeholder="Status"
                                v-model="form.status"
                                :options="status"
                            ></v-select>
                            <span class="text-danger" v-show="stolError.status"
                                >Unesite naziv!</span
                            >
                        </v-form>
                    </div>
                    <div class="modal-footer">
                        <v-alert v-if="stolSpremljen" type="success"
                            >Stol uspješno uređen!</v-alert
                        >
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Zatvori
                        </button>
                        <button
                            @click="spremiStol()"
                            type="button"
                            class="btn btn-primary"
                        >
                            Spremi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    created() {
        this.dohvatiStolove();
    },
    data: () => ({
        stolovi: [],
        status: ["Dostupan", "Nedostupan"],
        form: {
            id: "",
            naziv: "",
            broj_gostiju: "",
            status: "",
        },
        stolError: {
            naziv: false,
            broj_gostiju: false,
            status: false,
        },
        loading: false,
        stolSpremljen: false,
        stolIzbrisan: false,
    }),
    methods: {
        dohvatiStolove() {
            this.loading = true;
            axios
                .get("http://127.0.0.1:8000/stolovi")
                .then((response) => {
                    this.loading = false;
                    this.stolovi = response.data.stolovi;
                })
                .catch((e) => {
                    console.log("Nešto pošlo krivo! Greška=" + e);
                });
        },
        dohvatiStol(stol) {
            this.stolSpremljen = false;
            this.form = {
                id: stol.id,
                naziv: stol.naziv,
                broj_gostiju: stol.broj_gostiju,
                status: stol.status,
            };
        },
        spremiStol() {
            this.form.naziv == ""
                ? (this.stolError.naziv = true)
                : (this.stolError.naziv = false);
            this.form.broj_gostiju == ""
                ? (this.stolError.broj_gostiju = true)
                : (this.stolError.broj_gostiju = false);
            this.form.status == ""
                ? (this.stolError.status = true)
                : (this.stolError.status = false);

            if (this.form.naziv && this.form.broj_gostiju && this.form.status) {
                axios
                    .post(
                        "http://127.0.0.1:8000/admin/stolovi/uredi/" +
                            this.form.id,
                        this.form
                    )
                    .then(() => {
                        this.stolSpremljen = true;
                        setTimeout(() => {
                            this.stolSpremljen = false;
                        }, 7000);
                        this.dohvatiStolove();
                        console.log("Stol je dodan!");
                    })
                    .catch((e) => {
                        console.log("Nešto pošlo krivo! Greška=" + e);
                    });
            }
        },
        izbrisiStol(id) {
            axios
                .get("http://127.0.0.1:8000/admin/stolovi/izbrisi/" + id)
                .then(() => {
                    this.dohvatiStolove();
                    this.stolIzbrisan = true;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>
