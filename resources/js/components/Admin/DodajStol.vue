<template>
    <div>
        <v-alert v-if="stolDodan" type="success">
            Stol uspješno dodan!
        </v-alert>
        <form @keydown="clearError">
            <input
                id="naziv"
                name="naziv"
                placeholder="Naziv"
                type="text"
                v-model="form.naziv"
                class="form-control"
                :class="hasError('naziv') ? 'is-invalid' : ''"
            />
            <div v-if="hasError('naziv')" class="invalid-feedback">
                {{ getError("naziv") }}
            </div>

            <input
                id="broj_gostiju"
                name="broj_gostiju"
                placeholder="Broj gostiju"
                type="integer"
                v-model="form.broj_gostiju"
                class="form-control"
                :class="hasError('broj_gostiju') ? 'is-invalid' : ''"
            />
            <div v-if="hasError('broj_gostiju')" class="invalid-feedback">
                {{ getError("broj_gostiju") }}
            </div>

            <select
                @change="clearError"
                id="status"
                name="status"
                v-model="form.status"
                class="form-select"
                aria-label="Default select example"
                :class="hasError('status') ? 'is-invalid' : ''"
            >
                <option selected value="">Status stola</option>
                <option value="Dostupan">Dostupan</option>
                <option value="Nedostupan">Nedostupan</option>
            </select>
            <div v-if="hasError('status')" class="invalid-feedback">
                {{ getError("status") }}
            </div>
        </form>
        <v-btn color="success" class="mr-4" @click="dodajStol()">Dodaj</v-btn>
    </div>
</template>

<script>
export default {
    data: () => ({
        form: {
            naziv: "",
            broj_gostiju: "",
            status: "",
        },
        stolError: {
            naziv: false,
            broj_gostiju: false,
            status: false,
        },
        stolDodan: false,
        errors: {},
    }),
    methods: {
        dodajStol() {
            axios
                .post("http://127.0.0.1:8000/admin/stolovi/dodaj", this.form)
                .then(() => {
                    this.stolDodan = true;
                    setTimeout(() => {
                        this.stolDodan = false;
                        this.clearForm();
                        // window.location = "http://127.0.0.1:8000/admin";
                    }, 4000);
                    console.log("stol dodan");
                })
                .catch((e) => {
                    if (e.response.status == 422) {
                        this.errors = e.response.data.errors;
                    }
                    console.log("Nešto pošlo krivo! Greška=" + e);
                });
        },
        hasError(fieldName) {
            return fieldName in this.errors;
        },
        getError(fieldName) {
            return this.errors[fieldName][0];
        },
        clearError(event) {
            delete this.errors[event.target.name];
        },
        clearForm() {
            this.form.naziv = "";
            this.form.broj_gostiju = "";
            this.form.status = "";
        },
    },
};
</script>
