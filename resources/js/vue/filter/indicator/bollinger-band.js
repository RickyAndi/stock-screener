const bollingerBand = {
    props: {
        modifier: Object,
        index: Number
    },
    data: {
        movingAveragePeriod: 20,
        standardDeviation: 2,
        inEditingNumber: false,
        inEditingTimeWindow: false,
        inEditingMA: false,
        inEditingSTD: false,

        number: 20,
        timeFrame: 'Daily',
        timeWindow: 'latest',
        availableTimeWindows: [{
            timeframe: 'Daily',
            options: [{
                    name: 'Latest',
                    value: 'latest'
                },
                {
                    name: '1 Day ago',
                    value: '-1d'
                },
                {
                    name: 'N days ago',
                    value: '-nd'
                },
                {
                    name: 'Within n days ago',
                    value: '-wnd'
                }
            ]
        }],
    },
    computed: {
        selectedTimeWindow() {
            const availableTimeWindows = this.availableTimeWindows
                .map(timeWindow => timeWindow.options)
                .reduce((allTimeWindows, timeWindows) => {
                    return allTimeWindows.concat(timeWindows)
                }, []);
            const selectedTimeWindow = availableTimeWindows.find(timeWindow => timeWindow.value == this.timeWindow);
            return selectedTimeWindow.name;
        }
    },
    methods: {
        activateEditingNumber() {
            this.inEditingNumber = true;
            this.$nextTick(() => {
                setTimeout(() => {
                    this.$refs.numberInput.focus();
                }, 100);
            });
        },
        inactivateEditingNumber() {
            this.inEditingNumber = false;
        },
        activateEditingTimeWindow() {
            this.inEditingTimeWindow = true;
            this.$nextTick(() => {
                this.$refs.timeWindowSelect.focus();
            });
        },
        inactivateEditingTimeWindow() {
            this.inEditingTimeWindow = false;
        },
        activateEditingMAPeriode() {
            this.inEditingMA = true;
            this.$nextTick(() => {
                this.$refs.maInput.focus();
            });
        },
        inactivateEditingMAPeriode() {
            this.inEditingMA = false;
        },
        activateEditingSTD() {
            this.inEditingSTD = true;
            this.$nextTick(() => {
                this.$refs.stdInput.focus();
            });
        },
        inactivateEditingSTD() {
            this.inEditingSTD = false;
        },
        emitPayload() {
            this.$emit('payloadUpdated', {
                index: this.index,
                type: this.type,
                data: {
                    number: this.number,
                    movingAveragePeriod: this.movingAveragePeriod,
                    standardDeviation: this.standardDeviation,
                    timeFrame: this.timeFrame,
                    timeWindow: this.timeWindow
                }
            });
        }
    }
};

export default bollingerBand;