const arithmeticOperations = {
    name: "Arithmetic Operation",
    parentType: "Arithmetic Operation",
    options: [{
            name: "+",
            component: "Plus"
        },
        {
            name: "-",
            component: "Minus"
        },
        {
            name: "*",
            component: "Time"
        },
        {
            name: "/",
            component: "Divide"
        }
    ]
};

const comparisonOperations = {
    name: "Comparison Operation",
    parentType: "Comparison Operation",
    options: [{
            name: "=",
            component: "Equals"
        },
        {
            name: "!=",
            component: "NotEquals"
        },
        {
            name: ">",
            component: "GreaterThan"
        },
        {
            name: ">=",
            component: "GreaterThanEqualTo"
        },
        {
            name: "<",
            component: "LessThan"
        },
        {
            name: "<=",
            component: "LessThanEqualTo"
        },
    ]
};

const crossOperations = {
    name: "Cross Operation",
    parentType: "Cross Operation",
    options: [{
            name: "Crossed Above",
            component: "CrossedAbove"
        },
        {
            name: "Crossed Below",
            component: "CrossedBelow"
        }
    ]
};

const measures = {
    name: "Measures",
    parentType: "Measures",
    options: [{
        name: "Number",
        component: "Number"
    }]
};

const bollingerBands = {
    name: "Bollinger Band",
    parentType: "Bollinger Band",
    options: [{
            name: "Lower Bollinger Band",
            component: "LowerBollingerBand"
        },
        {
            name: "Upper Bollinger Band",
            component: "UpperBollingerBand"
        }
    ]
};

const stockAttributes = {
    name: "Stock Attributes",
    parentType: "StockAttribute",
    options: [{
            name: "Open",
            component: "Open"
        },
        {
            name: "High",
            component: "High"
        },
        {
            name: "Low",
            component: "Low"
        },
        {
            name: "Close",
            component: "Close"
        }
    ]
};

export {
    stockAttributes,
    bollingerBands,
    measures,
    crossOperations,
    comparisonOperations,
    arithmeticOperations
};