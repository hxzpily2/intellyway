dojo.provide("dojo._base.Deferred");
dojo.require("dojo._base.lang");

(function(){
	var mutator = function(){};		
	var freeze = Object.freeze || function(){};
	// A deferred provides an API for creating and resolving a promise.
	dojo.Deferred = function(/*Function?*/canceller){
	// summary:
	//		Deferreds provide a generic means for encapsulating an asynchronous
	// 		operation and notifying users of the completion and result of the operation. 
	// description:
	//		The dojo.Deferred API is based on the concept of promises that provide a
	//		generic interface into the eventual completion of an asynchronous action.
	//		The motivation for promises fundamentally is about creating a 
	//		separation of concerns that allows one to achieve the same type of 
	//		call patterns and logical data flow in asynchronous code as can be 
	//		achieved in synchronous code. Promises allows one 
	//		to be able to call a function purely with arguments needed for 
	//		execution, without conflating the call with concerns of whether it is 
	//		sync or async. One shouldn't need to alter a call's arguments if the 
	//		implementation switches from sync to async (or vice versa). By having 
	//		async functions return promises, the concerns of making the call are 
	//		separated from the concerns of asynchronous interaction (which are 
	//		handled by the promise).
	// 
	//  	The dojo.Deferred is a type of promise that provides methods for fulfilling the 
	// 		promise with a successful result or an error. The most important method for 
	// 		working with Dojo's promises is the then() method, which follows the 
	// 		CommonJS proposed promise API. An example of using a Dojo promise:
	//		
	//		| 	var resultingPromise = someAsyncOperation.then(function(result){
	//		|		... handle result ...
	//		|	},
	//		|	function(error){
	//		|		... handle error ...
	//		|	});
	//	
	//		The .then() call returns a new promise that represents the result of the 
	// 		execution of the callback. The callbacks will never affect the original promises value.
	//
	//		The dojo.Deferred instances also provide the following functions for backwards compatibility:
	//
	//			* addCallback(handler)
	//			* addErrback(handler)
	//			* callback(result)
	//			* errback(result)
	//
	//		Callbacks are allowed to return promisesthemselves, so
	//		you can build complicated sequences of events with ease.
	//
	//		The creator of the Deferred may specify a canceller.  The canceller
	//		is a function that will be called if Deferred.cancel is called
	//		before the Deferred fires. You can use this to implement clean
	//		aborting of an XMLHttpRequest, etc. Note that cancel will fire the
	//		deferred with a CancelledError (unless your canceller returns
	//		another kind of error), so the errbacks should be prepared to
	//		handle that error for cancellable Deferreds.
	// example:
	//	|	var deferred = new dojo.Deferred();
	//	|	setTimeout(function(){ deferred.callback({success: true}); }, 1000);
	//	|	return deferred;
	// example:
	//		Deferred objects are often used when making code asynchronous. It
	//		may be easiest to write functions in a synchronous manner and then
	//		split code using a deferred to trigger a response to a long-lived
	//		operation. For example, instead of register a callback function to
	//		denote when a rendering operation completes, the function can
	//		simply return a deferred:
	//
	//		|	// callback style:
	//		|	function renderLotsOfData(data, callback){
	//		|		var success = false
	//		|		try{
	//		|			for(var x in data){
	//		|				renderDataitem(data[x]);
	//		|			}
	//		|			success = true;
	//		|		}catch(e){ }
	//		|		if(callback){
	//		|			callback(success);
	//		|		}
	//		|	}
	//
	//		|	// using callback style
	//		|	renderLotsOfData(someDataObj, function(success){
	//		|		// handles success or failure
	//		|		if(!success){
	//		|			promptUserToRecover();
	//		|		}
	//		|	});
	//		|	// NOTE: no way to add another callback here!!
	// example:
	//		Using a Deferred doesn't simplify the sending code any, but it
	//		provides a standard interface for callers and senders alike,
	//		providing both with a simple way to service multiple callbacks for
	//		an operation and freeing both sides from worrying about details
	//		such as "did this get called already?". With Deferreds, new
	//		callbacks can be added at any time.
	//
	//		|	// Deferred style:
	//		|	function renderLotsOfData(data){
	//		|		var d = new dojo.Deferred();
	//		|		try{
	//		|			for(var x in data){
	//		|				renderDataitem(data[x]);
	//		|			}
	//		|			d.callback(true);
	//		|		}catch(e){ 
	//		|			d.errback(new Error("rendering failed"));
	//		|		}
	//		|		return d;
	//		|	}
	//
	//		|	// using Deferred style
	//		|	renderLotsOfData(someDataObj).then(null, function(){
	//		|		promptUserToRecover();
	//		|	});
	//		|	// NOTE: addErrback and addCallback both return the Deferred
	//		|	// again, so we could chain adding callbacks or save the
	//		|	// deferred for later should we need to be notified again.
	// example:
	//		In this example, renderLotsOfData is syncrhonous and so both
	//		versions are pretty artificial. Putting the data display on a
	//		timeout helps show why Deferreds rock:
	//
	//		|	// Deferred style and async func
	//		|	function renderLotsOfData(data){
	//		|		var d = new dojo.Deferred();
	//		|		setTimeout(function(){
	//		|			try{
	//		|				for(var x in data){
	//		|					renderDataitem(data[x]);
	//		|				}
	//		|				d.callback(true);
	//		|			}catch(e){ 
	//		|				d.errback(new Error("rendering failed"));
	//		|			}
	//		|		}, 100);
	//		|		return d;
	//		|	}
	//
	//		|	// using Deferred style
	//		|	renderLotsOfData(someDataObj).then(null, function(){
	//		|		promptUserToRecover();
	//		|	});
	//
	//		Note that the caller doesn't have to change his code at all to
	//		handle the asynchronous case.
		var result, finished, isError, head, nextListener;
		var promise = this.promise = {};
		
		function complete(value){
			if(finished){
				throw new Error("This deferred has already been resolved");				
			}
			result = value;
			finished = true;
			notify();
		}
		function notify(){
			var mutated;
			while(!mutated && nextListener){
				var listener = nextListener;
				nextListener = nextListener.next;
				if(mutated = (listener.progress == mutator)){ // assignment and check
					finished = false;
				}
				var func = (isError ? listener.error : listener.resolved);
				if (func) {
					try {
						var newResult = func(result);
						if (newResult && typeof newResult.then === "function") {
							newResult.then(listener.deferred.resolve, listener.deferred.reject);
							continue;
						}
						var unchanged = mutated && newResult === undefined;
						listener.deferred[unchanged && isError ? "reject" : "resolve"](unchanged ? result : newResult);
					}
					catch (e) {
						listener.deferred.reject(e);
					}
				}else {
					if(isError){
						listener.deferred.reject(result);
					}else{
						listener.deferred.resolve(result);
					}
				}
			}	
		}
		// calling resolve will resolve the promise
		this.resolve = this.callback = function(value){
			// summary:
			//		Fulfills the Deferred instance successfully with the provide value
			this.fired = 0;
			this.results = [value, null];
			complete(value);
		};
		
		
		// calling error will indicate that the promise failed
		this.reject = this.errback = function(error){
			// summary:
			//		Fulfills the Deferred instance as an error with the provided error 
			isError = true;
			this.fired = 1;
			complete(error);
			this.results = [null, error];
			if(!error || error.log !== false){
				(dojo.config.deferredOnError || function(x){ console.error(x); })(error);
			}
		};
		// call progress to provide updates on the progress on the completion of the promise
		this.progress = function(update){
			// summary
			//		Send progress events to all listeners
			var listener = nextListener;
			while(listener){
				var progress = listener.progress;
				progress && progress(update);
				listener = listener.next;	
			}
		};
		this.addCallbacks = function(/*Function?*/callback, /*Function?*/errback){
			this.then(callback, errback, mutator);
			return this;
		};
		// provide the implementation of the promise
		this.then = promise.then = function(/*Function?*/resolvedCallback, /*Function?*/errorCallback, /*Function?*/progressCallback){
			// summary
			// 		Adds a fulfilledHandler, errorHandler, and progressHandler to be called for 
			// 		completion of a promise. The fulfilledHandler is called when the promise 
			// 		is fulfilled. The errorHandler is called when a promise fails. The 
			// 		progressHandler is called for progress events. All arguments are optional 
			// 		and non-function values are ignored. The progressHandler is not only an 
			// 		optional argument, but progress events are purely optional. Promise 
			// 		providers are not required to ever create progress events.
			// 
			// 		This function will return a new promise that is fulfilled when the given 
			// 		fulfilledHandler or errorHandler callback is finished. This allows promise 
			// 		operations to be chained together. The value returned from the callback 
			// 		handler is the fulfillment value for the returned promise. If the callback 
			// 		throws an error, the returned promise will be moved to failed state.
			//	
			// example:
			// 		An example of using a CommonJS compliant promise:
  			//		|	asyncComputeTheAnswerToEverything().
			//		|		then(addTwo).
			//		|		then(printResult, onError);
  			//		|	>44 
			// 		
			var returnDeferred = progressCallback == mutator ? this : new dojo.Deferred(promise.cancel);
			var listener = {
				resolved: resolvedCallback, 
				error: errorCallback, 
				progress: progressCallback, 
				deferred: returnDeferred
			}; 
			if(nextListener){
				head = head.next = listener;
			}
			else{
				nextListener = head = listener;
			}
			if(finished){
				notify();
			}
			return returnDeferred.promise;
		};
		var deferred = this;
		this.cancel = promise.cancel = function () {
			// summary:
			//		Cancels the asynchronous operation
			if(!finished){
				var error = canceller && canceller(this);
				if (!(error instanceof Error)) {
					error = new Error(error);
				}
				error.log = false;
				deferred.reject(error);
			}
		}
		freeze(promise);
	};
	dojo.extend(dojo.Deferred, {
		addCallback: function (/*Function*/callback) {
			return this.addCallbacks(dojo.hitch.apply(dojo, arguments));
		},
	
		addErrback: function (/*Function*/errback) {
			return this.addCallbacks(null, dojo.hitch.apply(dojo, arguments));
		},
	
		addBoth: function (/*Function*/callback) {
			var enclosed = dojo.hitch.apply(dojo, arguments);
			return this.addCallbacks(enclosed, enclosed);
		},
		fired: -1
	});
})();
dojo.when = function(promiseOrValue, /*Function?*/callback, /*Function?*/errback, /*Function?*/progressHandler){
	// summary:
	//		This provides normalization between normal synchronous values and 
	//		asynchronous promises, so you can interact with them in a common way
	//	example:
	//		|	function printFirstAndList(items){
	//		|		dojo.when(findFirst(items), console.log);
	//		|		dojo.when(findLast(items), console.log);
	//		|	}
	//		|	function findFirst(items){
	//		|		return dojo.when(items, function(items){
	//		|			return items[0];
	//		|		});
	//		|	}
	//		|	function findLast(items){
	//		|		return dojo.when(items, function(items){
	//		|			return items[items.length];
	//		|		});
	//		|	}
	//		And now all three of his functions can be used sync or async.
	//		|	printFirstAndLast([1,2,3,4]) will work just as well as
	//		|	printFirstAndLast(dojo.xhrGet(...));
	
	if(promiseOrValue && typeof promiseOrValue.then === "function"){
		return promiseOrValue.then(callback, errback, progressHandler);
	}
	return callback(promiseOrValue);
};
