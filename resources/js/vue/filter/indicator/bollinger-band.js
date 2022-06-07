const bollingerBand = {
    props: {
        modifier: Object,
        index: Number
    },
    data: {
        movingAveragePeriod: 20,
        standardDeviation: 2
    },
    methods: {
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